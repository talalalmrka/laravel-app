/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
import { Dom } from "../../../core/dom/dom.js";
import { $$, attr, isFunction } from "../../../core/helpers/index.js";
import { UIBlock, UIButton, UIForm, UIInput } from "../../../core/ui/index.js";
import { TabsWidget } from "../tabs/tabs.js";
/**
 * Generate 3 tabs
 * upload - Use Drag and Drop
 * url - By specifying the image url
 * filebrowser - After opening the file browser. In the absence of one of the parameters will be less tabs
 *
 * @param callbacks - Object with keys `url`, `upload` and `filebrowser`, values which are callback
 * functions with different parameters
 */
export const FileSelectorWidget = (editor, callbacks, elm, close, isImage = true) => {
    let currentImage;
    const tabs = [];
    if (callbacks.upload &&
        editor.o.uploader &&
        (editor.o.uploader.url || editor.o.uploader.insertImageAsBase64URI)) {
        const dragBox = editor.c.fromHTML('<div class="jodit-drag-and-drop__file-box">' +
            `<strong>${editor.i18n(isImage ? 'Drop image' : 'Drop file')}</strong>` +
            `<span><br>${editor.i18n('or click')}</span>` +
            `<input type="file" accept="${isImage ? 'image/*' : '*'}" tabindex="-1" dir="auto" multiple=""/>` +
            '</div>');
        editor.uploader.bind(dragBox, resp => {
            const handler = isFunction(callbacks.upload)
                ? callbacks.upload
                : editor.o.uploader.defaultHandlerSuccess;
            if (isFunction(handler)) {
                handler.call(editor, resp);
            }
            editor.e.fire('closeAllPopups');
        }, error => {
            editor.message.error(error.message);
            editor.e.fire('closeAllPopups');
        });
        tabs.push({
            icon: 'upload',
            name: 'Upload',
            content: dragBox
        });
    }
    if (callbacks.filebrowser) {
        if (editor.o.filebrowser.ajax.url || editor.o.filebrowser.items.url) {
            tabs.push({
                icon: 'folder',
                name: 'Browse',
                content: () => {
                    close && close();
                    if (callbacks.filebrowser) {
                        editor.filebrowser.open(callbacks.filebrowser, isImage);
                    }
                }
            });
        }
    }
    if (callbacks.url) {
        const button = new UIButton(editor, {
            type: 'submit',
            variant: 'primary',
            text: 'Insert'
        }), form = new UIForm(editor, [
            new UIInput(editor, {
                required: true,
                label: 'URL',
                name: 'url',
                type: 'text',
                placeholder: 'https://'
            }),
            new UIInput(editor, {
                name: 'text',
                label: 'Alternative text'
            }),
            new UIBlock(editor, [button])
        ]);
        currentImage = null;
        if (elm &&
            !Dom.isText(elm) &&
            !Dom.isComment(elm) &&
            (Dom.isTag(elm, 'img') || $$('img', elm).length)) {
            currentImage = elm.tagName === 'IMG' ? elm : $$('img', elm)[0];
            val(form.container, 'input[name=url]', attr(currentImage, 'src'));
            val(form.container, 'input[name=text]', attr(currentImage, 'alt'));
            button.state.text = 'Update';
        }
        if (elm && Dom.isTag(elm, 'a')) {
            val(form.container, 'input[name=url]', attr(elm, 'href'));
            val(form.container, 'input[name=text]', attr(elm, 'title'));
            button.state.text = 'Update';
        }
        form.onSubmit(data => {
            if (isFunction(callbacks.url)) {
                callbacks.url.call(editor, data.url, data.text);
            }
        });
        tabs.push({
            icon: 'link',
            name: 'URL',
            content: form.container
        });
    }
    return TabsWidget(editor, tabs);
};
function val(elm, selector, value) {
    const child = elm.querySelector(selector);
    if (!child) {
        return '';
    }
    if (value) {
        child.value = value;
    }
    return child.value;
}
