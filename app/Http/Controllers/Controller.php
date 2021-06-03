<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * REGISTROS POR PÁGINA
     */
    protected $per_page = 18;

    /**
     * TÍTULO DA PÁGINA
     */
    protected $title_page = '';

    /**
     * ÍCONE DA PÁGINA
     */
    protected $title_icon = '';

}
