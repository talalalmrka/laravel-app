/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2025 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */
/**
 * @module request
 */
import type { IRequest, IResponse } from "../../types/index";
export declare class Response<T> implements IResponse<T> {
    readonly status: number;
    readonly statusText: string;
    readonly request: IRequest;
    get url(): string;
    private readonly body;
    constructor(request: IRequest, status: number, statusText: string, body: string | Blob);
    json(): Promise<T>;
    text(): Promise<string>;
    blob(): Promise<Blob>;
}
