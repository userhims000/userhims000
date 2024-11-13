<?php

namespace Rokit\Frame;

use Timber\Request as BaseRequest;
use Timber\URLHelper;

class Request extends BaseRequest {

    public function getUri() {
        return URLHelper::get_current_url();
    }

}