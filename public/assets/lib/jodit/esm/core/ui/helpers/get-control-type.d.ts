/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module ui
 */
import type { CanUndef, Controls, IControlType, IControlTypeStrong } from "../../../types/index";
/**
 * Get control for button name
 * @private
 */
export declare function getControlType(button: IControlType | string, controls: CanUndef<Controls>): IControlTypeStrong;
/**
 * @private
 */
export declare function findControlType(path: string, controls: Controls): IControlTypeStrong | void;
