/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module plugins/enter
 */
import type { HTMLTagNames, IJodit } from "../../../types/index";
/**
 * Checks if the cursor is on the edge of a special tag and exits if so
 * @private
 */
export declare function moveCursorOutFromSpecialTags(jodit: IJodit, fake: Text, tags: HTMLTagNames[]): void;
