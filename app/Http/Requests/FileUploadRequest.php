<?php

namespace App\Http\Requests;

use App\Helpers\ValidationHelper;

class FileUploadRequest extends BaseFormRequest
{
    /**
     * Xác định user có được phép thực hiện request này không
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy các quy tắc validation cho request upload file
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,xlsx,xls'],
            'folder' => ['sometimes', 'string', 'max:255'],
            'is_image' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Lấy thông báo lỗi tùy chỉnh cho validator
     */
    public function messages(): array
    {
        return [
            'file.required' => 'Vui lòng chọn file để upload',
            'file.file' => 'Trường :attribute phải là file hợp lệ',
            'file.max' => 'File không được vượt quá :max KB',
            'file.mimes' => 'File phải có định dạng: :values',
            'folder.string' => 'Thư mục phải là chuỗi ký tự',
            'folder.max' => 'Tên thư mục không được vượt quá :max ký tự',
            'is_image.boolean' => 'Loại hình ảnh phải là true hoặc false',
        ];
    }

    /**
     * Lấy tên thuộc tính tùy chỉnh cho lỗi validator
     */
    public function attributes(): array
    {
        return [
            'file' => 'file',
            'folder' => 'thư mục',
            'is_image' => 'loại hình ảnh',
        ];
    }
}