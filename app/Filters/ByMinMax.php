<?php
    namespace App\Filters;
    class ByMinMax{
        public function handle($request, \Closure $next){
            $builder = $next($request);

            // Kiểm tra nếu có yêu cầu sắp xếp theo giá
            if (request()->has('amount_start') && request()->has('amount_end')) {
                // Thực hiện sắp xếp theo giá từ thấp đến cao hoặc từ cao đến thấp
                $sortDirection = request()->query('sort_direction_start', 'asc');

                // Sử dụng $sortDirection để xác định hướng sắp xếp
                $builder->whereBetween('price', [request()->query('amount_start'), request()->query('amount_end')])
                        ->orderBy('price', $sortDirection);
            }

            return $builder;
        }
    }
?>
