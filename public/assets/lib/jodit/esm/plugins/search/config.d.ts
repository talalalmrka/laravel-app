/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module plugins/search
 */
import type { FuzzySearch } from "../../types/index";
import "./interface";
declare module 'jodit/config' {
    interface Config {
        /**
         * Enable custom search plugin
         * ![search](https://user-images.githubusercontent.com/794318/34545433-cd0a9220-f10e-11e7-8d26-7e22f66e266d.gif)
         */
        useSearch: boolean;
        search: {
            lazyIdleTimeout: number;
            /**
             * Use custom highlight API https://developer.mozilla.org/en-US/docs/Web/API/CSS_Custom_Highlight_API
             * or use default implementation (wrap text in span and attribute jd-tmp-selection)
             */
            useCustomHighlightAPI: boolean;
            /**
             * Function to search for a string within a substring. The default implementation is [[fuzzySearchIndex]]
             * But you can write your own. It must implement the [[FuzzySearch]] interface.
             *
             * ```ts
             * Jodit.make('#editor', {
             *   search: {
             *     fuzzySearch: (needle, haystack, offset) => {
             *       return [haystack.toLowerCase().indexOf(needle.toLowerCase(), offset), needle.length];
             *     }
             *   }
             * })
             * ```
             */
            fuzzySearch?: FuzzySearch;
        };
    }
}
