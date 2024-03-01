<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Settings';
        $data["can_edit"] = Auth::user()->Has_permission("edit_settings");
        return view("webmaster.settings.index")->with("data", $data);
    }
    
    public function edit(Request $request)
    {
        $data = $request->all();
        $data["logo"] = config('settings.logo');
        if ($request->hasFile('logo')) {
            $logoName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('img/images'), $logoName);
            $data['logo'] = 'images/'.$logoName;
        }

        $data['logo_tall'] = config('settings.logo_tall');
        if ($request->hasFile('logo_tall')) {
            $logoTallName = time() . '_' . $request->file('logo_tall')->getClientOriginalName();
            $request->file('logo_tall')->move(public_path('img/images'), $logoTallName);
            $data['logo_tall'] = 'images/'.$logoTallName;
        }

        $data['icon'] = config('settings.icon');
        if ($request->hasFile('icon')) {
            $logoTallName = time() . '_' . $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('img/images'), $logoTallName);
            $data['icon'] = 'images/'.$logoTallName;
        }

        $data['icon'] = config('settings.icon');
        if ($request->hasFile('icon')) {
            $logoTallName = time() . '_' . $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('img/images'), $logoTallName);
            $data['icon'] = 'images/'.$logoTallName;
        }
        for($i=1;$i<=6;$i++)
        {
            $data['feature'.$i]['picture'] = config('settings.feature'.$i)['picture'];
            if ($request->hasFile('feature'.$i)) {
                if(array_key_exists('picture', $request['feature'.$i]))
                {
                    $picture = time() . '_' . $request->file('feature'.$i)['picture']->getClientOriginalName();
                    $request->file('feature'.$i)['picture']->move(public_path('img/website/features/'), $picture);
                    $data['feature'.$i]['picture'] = 'website/features/'.$picture;
                }
            }
        }
        $data['slider']['picture'] = config('settings.slider')['picture'];
        if ($request->hasFile('slider')) {
            if(array_key_exists('picture', $request['slider']))
            {
                $picture = time() . '_' . $request->file('slider')['picture']->getClientOriginalName();
                $request->file('slider')['picture']->move(public_path('img/website/slider/'), $picture);
                $data['slider']['picture'] = 'website/slider/'.$picture;
            }
        }
        
        foreach($data as $key=>$value){
            if(is_array($value)){
                foreach($value as $key2=>$value2){
                    $setting = Setting::where("title", $key.'%%'.$key2)->first();
                    if($setting){
                        $setting->update([
                            'title' => $key.'%%'.$key2,
                            'content' => $value2,
                            'updated_by' => Auth::user()->id
                        ]);
                    }else{
                        Setting::create([
                            'title' => $key.'%%'.$key2,
                            'content' => $value2,
                            'updated_by' => Auth::user()->id
                        ]);
                    }
                }
            }else{
                $setting = Setting::where("title", $key)->first();
                if($setting){
                    $setting->update([
                        'title' => $key,
                        'content' => $value,
                        'updated_by' => Auth::user()->id
                    ]);
                }else{
                    Setting::create([
                        'title' => $key,
                        'content' => $value,
                        'updated_by' => Auth::user()->id
                    ]);
                }
            }
        }
        return redirect()->route('webmaster_settings_index')->with('success', 'Settings updated successfully');
    }
}
