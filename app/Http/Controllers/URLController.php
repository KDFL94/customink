<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class URLController extends BaseController
{
    public function handleRedirect(Request $request) 
    {
        // get path
        $path = substr($request->path(), 10);
        $url = URL::where('custom_slug', $path)->firstOrFail();

        // redirect user
        return Redirect::to($url->redirect_to);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [ 
            'custom_slug' => 'required|unique:urls',
            'redirect_to' => 'required|url'
        ]);

        if ( $validator->fails() ) {
            $errors = $validator->errors();

            // send error
            return $this->sendError($errors, 'Please fix the form errors.', 200);
        }

        $url = URL::create([
            'custom_slug' => $request->input('custom_slug'),
            'redirect_to' => $request->input('redirect_to')
        ]);

        if ( !$url ) {
            // send error
            return $this->sendError([], 'There was an issue creating the URL redirect.', 502);
        }

        // prepare new table row
        $app_url = url('/');
        $newTR = '<tr>
            <th scope="row">' . $url->id . '</th>
            <td>
                <a 
                    href="#" 
                    title="' . $url->redirect_to . '"
                    data-full-url="' . $url->redirect_to . '"
                    data-custom-url="' . $app_url . '/redirects/' . $url->custom_slug . '"
                    class="expand-url"
                    >' . $app_url . '/redirects/' . $url->custom_slug . '</a>
            </td>
            <td>
                <a 
                    href="' . $url->redirect_to . '" 
                    target="_blank"
                    class="btn btn-primary">Original Link</a>
                <a 
                    href="' . $app_url . '/redirects/ ' . $url->custom_slug . '" 
                    target="_blank"
                    class="btn btn-success">Custom Link</a>
            </td>
        </tr>';

        // send success
        return $this->sendResponse($newTR, 'Successfully added the new URL redirect.');
    }
}
