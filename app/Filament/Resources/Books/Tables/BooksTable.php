<?php

namespace App\Filament\Resources\Books\Tables;

use App\Models\Book;
use App\Models\Profile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Book::query()
                    ->selectRaw('book.*, ROW_NUMBER() OVER (ORDER BY created_at desc) as row_num')
                    ->orderBy('created_at', direction: 'desc') // urutkan tampilannya dari terbaru
            )
            ->columns([
                //
                TextColumn::make('row_num')
                    ->label('No')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('descriptions')
                    ->label('Deskripsi')
                    ->formatStateUsing(fn ($state) => Str::limit($state, 50))
                    ->html()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->default('belum ditentukan')
                    ->sortable(),

                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $userId = Auth::id();
                        $profile = Profile::where('idUsers', $userId)->first();
                        $data['name'] = 'ujang';

                        return $data;
                    }),
                DeleteAction::make()
                    ->button()
                    ->color('danger') // default abu-abu (tidak merah)
                    ->requiresConfirmation() // pastikan tampil popup konfirmasi
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('apakah yakin ingin menghapus data ini?')
                    ->modalSubmitActionLabel('Ya, Hapus'),
            ])
            
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
