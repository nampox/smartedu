<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'collection_name' => $this->collection_name,
            'disk' => $this->disk,
            'conversions_disk' => $this->conversions_disk,
            'manipulations' => $this->manipulations,
            'custom_properties' => $this->custom_properties,
            'generated_conversions' => $this->generated_conversions,
            'responsive_images' => $this->responsive_images,
            'order_column' => $this->order_column,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // URLs
            'url' => $this->getUrl(),
            'thumb_url' => $this->getUrl('thumb'),
            'medium_url' => $this->getUrl('medium'),
            'large_url' => $this->getUrl('large'),
            
            // Model relationship
            'model' => $this->whenLoaded('model', function () {
                return [
                    'id' => $this->model->id,
                    'type' => class_basename($this->model),
                    'name' => $this->model->name ?? 'Unknown',
                ];
            }),
            
            // Additional computed fields
            'formatted_size' => $this->getFormattedSize(),
            'extension' => $this->getExtension(),
            'is_image' => $this->isImage(),
            'is_video' => $this->isVideo(),
            'is_document' => $this->isDocument(),
        ];
    }

    /**
     * Get formatted file size
     */
    private function getFormattedSize(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file extension
     */
    private function getExtension(): string
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is image
     */
    private function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if file is video
     */
    private function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Check if file is document
     */
    private function isDocument(): bool
    {
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        
        return in_array($this->mime_type, $documentTypes);
    }
}