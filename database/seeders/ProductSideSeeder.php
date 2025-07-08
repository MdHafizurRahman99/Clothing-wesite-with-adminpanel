<?php

namespace Database\Seeders;

use App\Models\ProductSide;
use Illuminate\Database\Seeder;

class ProductSideSeeder extends Seeder
{
    public function run()
    {
        ProductSide::create([
            'product_id' => 'MPC-SZCRepudiandae modi sun2038874817',
            'side' => 'front',
            'design_area' => json_encode(['x' => 252, 'y' => 210, 'width' => 178, 'height' => 175]),
            'adjacent_side_mappings' => json_encode([
                'front' => [
                    [
                        'side' => 'left',
                        'x' => 405,
                        'y' => 220,
                        'scale' => 0.2,
                        'rotation' => -11,
                        'crop' => ['x' => 0, 'width' => 0.5] // Crop left half of left sleeve
                    ],
                    [
                        'side' => 'right',
                        'x' => 86,
                        'y' => 220,
                        'scale' => 0.2,
                        'rotation' => 11,
                        'crop' => ['x' => 0.5, 'width' => 0.5] // Crop right half of right sleeve
                    ]
                ]
            ])
        ]);

        ProductSide::create([
            'product_id' => 'MPC-SZCRepudiandae modi sun2038874817',
            'side' => 'back',
            'design_area' => json_encode(['x' => 252, 'y' => 210, 'width' => 178, 'height' => 175]),
            'adjacent_side_mappings' => json_encode([
                'back' => [
                    [
                        'side' => 'left',
                        'x' => 86,
                        'y' => 220,
                        'scale' => 0.2,
                        'rotation' => 11,
                        'crop' => ['x' => 0.5, 'width' => 0.5] // Crop right half of left sleeve
                    ],
                    [
                        'side' => 'right',
                        'x' => 405,
                        'y' => 220,
                        'scale' => 0.2,
                        'rotation' => -11,
                        'crop' => ['x' => 0, 'width' => 0.5] // Crop left half of right sleeve
                    ]
                ]
            ])
        ]);

        ProductSide::create([
            'product_id' => 'MPC-SZCRepudiandae modi sun2038874817',
            'side' => 'left',
            'design_area' => json_encode(['x' => 100, 'y' => 100, 'width' => 200, 'height' => 150]),
            'adjacent_side_mappings' => json_encode(['front' => [], 'back' => []])
        ]);

        ProductSide::create([
            'product_id' => 'MPC-SZCRepudiandae modi sun2038874817',
            'side' => 'right',
            'design_area' => json_encode(['x' => 100, 'y' => 100, 'width' => 200, 'height' => 150]),
            'adjacent_side_mappings' => json_encode(['front' => [], 'back' => []])
        ]);
    }
}
