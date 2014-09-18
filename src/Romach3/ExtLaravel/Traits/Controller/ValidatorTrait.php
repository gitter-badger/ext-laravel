<?php
namespace Romach3\ExtLaravel\Traits\Controller;

trait ValidatorTrait
{
    /**
     * Add row and redirect
     * @param $row "new \Modelname"
     * @param null $data \Input::all() by default
     * @param null $passes redirectPasses()
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function createOrBack($row, $data = null, $passes = null)
    {
        return $this->actionOrBack('create', $row, $data, $passes);
    }

    /**
     * Update row and redirect
     * @param $row - row
     * @param null $data - \Input::all() by default
     * @param null $passes redirectPasses()
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function updateOrBack($row, $data = null, $passes = null)
    {
        return $this->actionOrBack('update', $row, $data, $passes);
    }

    private function actionOrBack($action, $row, $data = null, $passes = null)
    {
        if (is_null($data)) {
            $data = \Input::all();
        }
        if (\Session::token() !== \Input::get('_token')) {
            return $this->badToken();
        }
        if ($action === 'update' && $row->update($data)) {
            return $this->redirectPasses($passes, $row);
        } elseif ($action === 'create') {
            $row = $row->create($data);
            if ($row->exists) {
                return $this->redirectPasses($passes, $row);
            }
        }
        return \Redirect::back()->withErrors($row->validator)->withInput();
    }

    /**
     * Редирект после успешного изменения записи
     * по умолчанию "@show($row->id)"
     * 'back' Redirect::back()
     * [action, params...]
     * "action"
     * closure (должно вернуть один из редиректов)
     * @param $passes
     * @param null $row
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function redirectPasses($passes, $row = null)
    {
        if (is_null($passes) && is_object($row)) {
            return \Redirect::action($this->controller('getView'), array($row->id));
        } elseif (is_array($passes) && count($passes) > 1) {
            $action = array_shift($passes);
            return \Redirect::action($action, $passes);
        } elseif ($passes === 'back') {
            return \Redirect::back();
        } elseif (is_string($passes)) {
            return \Redirect::action($passes);
        } elseif (is_callable($passes)) {
            return $passes($row);
        }
        \App::abort(404);
        return false;
    }

    protected function deleteOrBack($row, $token = null, $passes = 'back')
    {
        $token = \Input::has('_token') ? \Input::get('_token') : $token;
        if (\Session::token() !== $token) {
            return $this->badToken();
        }

        $row->delete();
        return $this->redirectPasses($passes, $row);
    }

    protected function validate($model, $key)
    {
        if (\Input::get('_token') !== \Session::token()) {
            return \Response::json(['result' => false, 'error' => false, 'message' => null]);
        }
        if (isset($model->rules[$key]) && \Input::has($key)) {
            $validator = \Validator::make(
                [$key => \Input::get($key)],
                [$key => $model->rules[$key]],
                $model->messages
            );
            if ($validator->fails()) {
                return \Response::json([
                    'result' => true,
                    'message' => $validator->messages()->first($key),
                    'error' => true
                ]);
            }
        }
        return \Response::json(['result' => true, 'error' => false, 'message' => null]);
    }

    protected function badToken()
    {
        return \Redirect::back();
    }
}
