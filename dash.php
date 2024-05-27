function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    die();
}

Redirect('http://82.180.136.148:3339/public-dashboards/2c77f4374db34cbd8344fd56e6951e6d', false);
