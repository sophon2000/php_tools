<?php 

//例一
//在函数里定义一个匿名函数，并且调用它
function printStr() {
    $func = function( $str ) {
        echo $str;
    };
    $func( 'some string' );
}

printStr();



//例二
//在函数中把匿名函数返回，并且调用它
function getPrintStrFunc() {
    $func = function( $str ) {
        echo $str;
    };
    return $func;
}

$printStrFunc = getPrintStrFunc();
$printStrFunc( 'some string' );




//例三
//把匿名函数当做参数传递，并且调用它
function callFunc( $func ) {
    $func( 'some string' );
}

$printStrFunc = function( $str ) {
    echo $str;
};
callFunc( $printStrFunc );

//也可以直接将匿名函数进行传递。如果你了解js，这种写法可能会很熟悉
callFunc( function( $str ) {
    echo $str;
} );