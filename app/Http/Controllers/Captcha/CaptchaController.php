<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Models\Survey\Captcha;

class CaptchaController extends Controller
{
    public function show(){
        $uuid = (string) Uuid::uuid4();

        // create phrases of 8 characters
        $phraseBuilder = new PhraseBuilder(8);

        $builder = new CaptchaBuilder(null, $phraseBuilder);

        // set width and height
        $builder->build(200, 50);
        $builder->save(storage_path('app/public/captcha/'.$uuid.'.jpg'));
        
        // save file name and value of captcha
        $captcha = New Captcha;
        $captcha->captcha_file_name = $uuid.'.jpg';
        $captcha->captcha_value     = $builder->getPhrase(); 
        $captcha->save(); 

        return json_encode([
            'data' => $uuid.'.jpg'
        ]);

    }
}
