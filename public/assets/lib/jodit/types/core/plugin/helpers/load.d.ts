/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module plugin
 */
import type { IExtraPlugin, IJodit, PluginType } from "../../../types/index";
/**
 * @private
 */
export declare function loadStyle(jodit: IJodit, pluginName: string): Promise<void>;
/**
 * @private
 */
export declare function loadExtras(items: Map<string, PluginType>, jodit: IJodit, extraList: IExtraPlugin[], callback: () => void): void;
