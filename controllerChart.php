
    public function chart()
    {
        $data = Kas::select([
            DB::raw("SUM(debit) as total_debit"),
            DB::raw("SUM(kredit) as total_kredit"),
            DB::raw("MONTH(created_at) as bln"),
            // DB::raw("YEAR(created_at) as year")
        ])
        ->whereYear('created_at', 2022)
            ->groupBy([
                'bln'
            ])
            ->orderBy('bln')
            ->get();

        $arrBln = [1 => 'Jan','Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $totalD = $totalK = [];
        foreach ($data as $tot) {
          $totalD[$tot->bln] = $tot->total_debit;
          $totalK[$tot->bln] = $tot->total_kredit;
        }

        foreach ($arrBln as $month =>$name){
            if(!array_key_exists($month, $totalD)){
                $totalD[$month]= 0;
            }
            if(!array_key_exists($month, $totalK)){
                $totalK[$month]= 0;
            }
        }

        ksort($totalD);
        ksort($totalK);

        return[
            'labels' => array_values($arrBln),
            'dataset' => [
                [
                    'label' => 'Pemasukan',
                    'data' => array_values($totalD),
                    'borderWidth'=> 2,
                    'backgroundColor'=> 'rgba(63,82,227,.8)',
                    'borderWidth' => 0,
                    'borderColor' =>'transparent',
                    'pointBorderWidth' => 0,
                    'pointRadius' => 3.5,
                    'pointBackgroundColor' => 'transparent',
                    'pointHoverBackgroundColor' => 'rgba(63,82,227,.8)',

                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => array_values($totalK),
                    'borderWidth'=> 2,
                   'backgroundColor' => 'rgba(254,86,83,.7)',
                    'borderWidth' => 0,
                    'borderColor' =>'transparent',
                    'pointBorderWidth'=> 0,
                    'pointRadius'=> 3.5,
                    'pointBackgroundColor'=> 'transparent',
                    'pointHoverBackgroundColor'=> 'rgba(254,86,83,.8)',

                ],
            ]
        ];
    }
