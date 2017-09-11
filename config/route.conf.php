<?php

Dispatcher::loadRoute(
    [
    '/^$/' => UI.'HomeAction',
    '/^ajax\/server\/add$/' => UI.'AjaxServerAddAction',
    ]
);
