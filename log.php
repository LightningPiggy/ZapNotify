<?php
// Test it with:
// curl -d "hereis=postdata" https://p.lightningpiggy.com/?getvariable=hasvalue
// Download metrics from:
// https://p.lightningpiggy.com/payment_metrics.csv

$outfile = "payment_metrics.csv";
$headers = "epochtime|ip address|query string|request|post";

function stripNewLines(string $input) {
    return preg_replace('/\R+/', ' ', $input);
}

function add(string $toadd) {
    return stripNewLines($toadd) . "|";
}

$towrite = "";
$towrite .= add(time());
$towrite .= add($_SERVER['REMOTE_ADDR']);
$towrite .= add(print_r($_REQUEST,true)); // Array (     [getvariable] => hasvalue     [hereis] => postdata )
// LNBits POSTs lots of info about the invoice that was paid:
$towrite .= add(file_get_contents('php://input')); // {"payment_hash": "0bcbc265bd4d6cac343c4b460767f3e4b9de38a87b03cbfb7170436f94c532e1", "payment_request": "lnbc100n1pjwc5wssp5hvmfc25fqs7ccald7nq02qfaecx70262rz3qk7x3xzzyrsx7jzjqpp5p09uyedaf4k2cdpufdrqwelnujuauw9g0vpuh7m3wppkl9x9xtsshp5gxwncgtpe3jmwprje9eyysh7ap0xe2ez8uy59s436xftc9vd0cdqxqzjccqpjrzjq027t9tsc6jn5ve2k6gnn689unn8h239juuf9s3ce09aty6ed73t5z7nqsqqsygqqyqqqqqqqqqqztqq9q9qxpqysgqypdyk2vxvct99ashdq538dfpua9hexr0z3wtyfkrkend3yz75z58phg6hhzlqymw4qsptgph5evk7nd6ywxn6a7eh4fuh4q5fz60amcpyxzg9t", "amount": 10000, "comment": ["Nice!"], "lnurlp": "5cvU6X", "body": ""}
$towrite .= "\n";

// This is not needed because it's logged by the $_REQUEST above:
//$towrite .= add($_SERVER['QUERY_STRING']); getvariable=hasvalue
// This is not needed because it's logged by the $_REQUEST above:
//$towrite .= add(print_r($_POST,true)); // Array (     [hereis] => postdata )


// Add headers if file is empty
clearstatcache();
if(!file_exists($outfile) || (filesize($outfile) == 0)) {
    $towrite = $headers . "\n" . $towrite;
}

$fp = file_put_contents($outfile, $towrite, FILE_APPEND);

echo "POK";