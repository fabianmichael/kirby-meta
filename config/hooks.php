<?php

return [
    'file.*:after' => function() {
        kirby()->cache('fabianmichael.meta')->flush();
    },
    'page.*:after' => function() {
        kirby()->cache('fabianmichael.meta')->flush();
    },
    'site.*:after' => function() {
        kirby()->cache('fabianmichael.meta')->flush();
    },
    'user.*:after' => function() {
        kirby()->cache('fabianmichael.meta')->flush();
    },
];
];
