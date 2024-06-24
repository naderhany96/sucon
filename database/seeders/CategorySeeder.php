<?php

namespace Database\Seeders;

use App\Models\{Media, Category};
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Mental Health',
                'image' => $this->getImageData('heart'),
                'children' => [
                    ['name' => 'Depression'],
                    ['name' => 'Anxiety & Stress'],
                ]
            ],
            [
                'name' => 'Trauma & Grief',
                'image' => $this->getImageData('angel'),
                'children' => [
                    ['name' => 'Loss'],
                    ['name' => 'Death'],
                ]
            ],
            [
                'name' => 'Parenthood',
                'image' => $this->getImageData('pen'),
                'children' => [
                    ['name' => 'Postpartum'],
                ]
            ],
        ];

        foreach ($categories as $category) 
        {    
            $parentCategory = Category::create(['name' => $category['name']]);

            if (isset($category['image']) && count($category['image']) > 0)

                $this->createCategoryImage(
                    $parentCategory, $category['image']['name'], $category['image']['path']
                );
            
            if (isset($category['children']) && count($category['children']) > 0)

                foreach ($category['children'] as $child)

                    Category::create(['name' => $child['name'], 'parent_id' => $parentCategory->id]);
        }
    }
    
    private function getImageData($name)
    {
        return ['name' => "$name.png", 'path' => "images/$name.png"];
    }

    private function createCategoryImage($entity, $name, $path)
    {
        Media::create([
            'mediable_id' => $entity->id,
            'mediable_type' => $entity::class,
            'name' => $name,
            'type' => "png",
            'path' => $path,
            'size' => "11.8 KB",
            'attribute' => "image"
        ]);
    }
}
