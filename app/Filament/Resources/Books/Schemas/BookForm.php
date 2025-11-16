<?php

namespace App\Filament\Resources\Books\Schemas;

use App\Models\Book;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //        'idCategory',

                TextInput::make('name')
                    ->label('Nama Buku')
                    ->required(),

                RichEditor::make('descriptions')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(), // supaya lebar penuh

                TextInput::make('link')
                    ->label('Tautan Buku')
                    ->required(),

                TextInput::make('price')
                    ->label('Harga Buku')
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->required(),
                
                Select::make('idCategory')
                    ->label('Kategori')
                    ->options(
                        Category::pluck('name', 'id')
                    )
                    ->preload()
                    ->placeholder('Pilih Kategori'),

                FileUpload::make('gambar')
                    ->disk('public_folder')
                    ->directory(fn ($record) => $record?->id 
                        ? "media/book/{$record->id}" 
                        : "media/book/temp"
                    )
                    ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                        $ext = $file->getClientOriginalExtension();
                        $datetime = now()->format('Ymd_His');
                        $id = $record?->id ?? 'new'; // fallback kalau belum ada id
                        return "book_{$datetime}_{$id}.{$ext}";
                    })
                    ->visibility('public')
                    ->preserveFilenames(false) // biar selalu generate nama sesuai fungsi di atas
                    ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public_folder')->delete($file)),
            ]);
    }
}
