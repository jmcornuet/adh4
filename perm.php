<?php
function pc_next_permutation($p, $size) {
    // slide down the array looking for where we're smaller than the next guy
    for ($i = $size - 1; $p[$i] >= $p[$i+1]; --$i) { }

    // if this doesn't occur, we've finished our permutations
    // the array is reversed: (1, 2, 3, 4) => (4, 3, 2, 1)
    if ($i == -1) { return false; }

    // slide down the array looking for a bigger number than what we found before
    for ($j = $size; $p[$j] <= $p[$i]; --$j) { }

    // swap them
    $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;

    // now reverse the elements in between by swapping the ends
    for (++$i, $j = $size; $i < $j; ++$i, --$j) {
         $tmp = $p[$i]; $p[$i] = $p[$j]; $p[$j] = $tmp;
    }

    return $p;
}

$set = split(' ', 'she sells seashells'); // like array('she', 'sells', 'seashells')
$size = count($set) - 1;
$perm = range(0, $size);
$j = 0;

do { 
     foreach ($perm as $i) { $perms[$j][] = $set[$i]; }
} while ($perm = pc_next_permutation($perm, $size) and ++$j);

foreach ($perms as $p) {
    print join(' ', $p) . "\n";
}

$size=3;
$perm = range (0, $size);print join('',$perm)."\n";
for ($k=0;$k<23;$k++) {
    $perm = pc_next_permutation($perm,$size);
    print join('',$perm)."\n";
} 
?>