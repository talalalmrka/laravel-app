/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @internal
 */
export declare function sound({ sec, frequency, gain, type }?: {
    sec?: number;
    frequency?: number;
    gain?: number;
    type?: 'sine' | 'square' | 'sawtooth' | 'triangle';
}): void;
