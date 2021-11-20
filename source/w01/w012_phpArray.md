## PHP 数组



### 数组初识

可以用 [array()](https://www.php.net/manual/zh/function.array.php) 语言结构来新建一个 array 。它接受任意数量用逗号分隔的 `键（key） => 值（value）` 对。

```php
array(
    key  => value,
    key2 => value2,
    key3 => value3,
    ...
)
```

最后一个数组单元之后的逗号可以省略。通常用于单行数组定义中，例如常用 `array(1, 2)` 而不是 `array(1, 2, )`。对多行数组定义通常保留最后一个逗号，这样要添加一个新单元时更方便。

**注意**:

- 可以用短数组语法 `[]` 替代 `array()` 。

**例子1:入门 ** 

```php
<?php
$array = array(
    "foo" => "bar",
    "bar" => "foo",
);

// 使用短数组语法
$array = [
    "foo" => "bar",
    "bar" => "foo",
];
?>
```

key 可以是 integer 或者 string。value 可以是任意类型。

此外 key 会有如下的强制转换：

- String 中包含有效的十进制 int，除非数字前面有一个 `+` 号，否则将被转换为 int 类型。例如键名 `"8"` 实际会被储存为 `8`。另外， `"08"` 不会被强制转换，因为它不是一个有效的十进制整数。
- Float 也会被转换为 int ，意味着其小数部分会被舍去。例如键名 `8.7` 实际会被储存为 `8`。
- Bool 也会被转换成 int。即键名 `true` 实际会被储存为 `1` 而键名 `false` 会被储存为 `0`。
- Null 会被转换为空字符串，即键名 `null` 实际会被储存为 `""`。
- Array 和 object *不能* 被用为键名。坚持这么做会导致警告：`Illegal offset type`。

如果在数组定义时多个元素都使用相同键名，那么只有最后一个会被使用，其它的元素都会被覆盖。

**例子2：类型转换与覆盖** 

```php
<?php
$array = array(
    1    => "a",
    "1"  => "b",
    1.5  => "c",
    true => "d",
);
var_dump($array);
?>
输出
---------
array(1) {
  [1]=>
  string(1) "d"
}
```

上例中所有的键名都被强制转换为 `1`，则每一个新单元都会覆盖前一个的值，最后剩下的只有一个 `"d"`。

PHP 数组可以同时含有 int 和 string 类型的键名，因为 PHP 实际并不区分索引数组和关联数组。

**例子3：混合int和string键值** 

```php
<?php
$array = array(
    "foo" => "bar",
    "bar" => "foo",
    100   => -100,
    -100  => 100,
);
var_dump($array);
?>
 输出
 ------
 array(4) {
  ["foo"]=>
  string(3) "bar"
  ["bar"]=>
  string(3) "foo"
  [100]=>
  int(-100)
  [-100]=>
  int(100)
}
```

key 为可选项。如果未指定，PHP 将自动使用之前用过的最大 int 键名加上 1 作为新的键名。

**例子4：没有键名的索引数组** 

```php
<?php
$array = array("foo", "bar", "hello", "world");
var_dump($array);
?>
    
输出
-------
array(4) {
  [0]=>
  string(3) "foo"
  [1]=>
  string(3) "bar"
  [2]=>
  string(5) "hello"
  [3]=>
  string(5) "world"
}
```

还可以只对某些单元指定键名而对其它的空置：

**例子5：仅对部分单元指定键名** 

```php
<?php
$array = array(
         "a",
         "b",
    6 => "c",
         "d",
);
var_dump($array);
?>
输出
------
array(4) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [6]=>
  string(1) "c"
  [7]=>
  string(1) "d"
}
```

可以看到最后一个值 `"d"` 被自动赋予了键名 `7`。这是由于之前最大的整数键名是 `6`。

**例子6：复杂类型转换和覆盖** 

这个例子包括键名类型转换和元素覆盖的所有变化。

```php
<?php
$array = array(
    1    => 'a',
    '1'  => 'b', // 值 "a" 会被 "b" 覆盖
    1.5  => 'c', // 值 "b" 会被 "c" 覆盖
    -1 => 'd',
    '01'  => 'e', // 由于这不是整数字符串，因此不会覆盖键名 1
    '1.5' => 'f', // 由于这不是整数字符串，因此不会覆盖键名 1
    true => 'g', // 值 "c" 会被 "g" 覆盖
    false => 'h',
    '' => 'i',
    null => 'j', // 值 "i" 会被 "j" 覆盖
    'k', // 值 “k” 的键名被分配为 2。这是因为之前最大的整数键是 1
    2 => 'l', // 值 "k" 会被 "l" 覆盖
);

var_dump($array);
?>
输出
----
array(7) {
  [1]=>
  string(1) "g"
  [-1]=>
  string(1) "d"
  ["01"]=>
  string(1) "e"
  ["1.5"]=>
  string(1) "f"
  [0]=>
  string(1) "h"
  [""]=>
  string(1) "j"
  [2]=>
  string(1) "l"
}
```

#### 1. 数组访问

##### 1.1 用方括号语法访问数组单元

数组单元可以通过 `array[key]` 语法来访问。

**例子7：访问数组单元** 

```php
<?php
$array = array(
    "foo" => "bar",
    42    => 24,
    "multi" => array(
         "dimensional" => array(
             "array" => "foo"
         )
    )
);

var_dump($array["foo"]);
var_dump($array[42]);
var_dump($array["multi"]["dimensional"]["array"]);
?>
```

以上例程会输出：

```
string(3) "bar"
int(24)
string(3) "foo"
```

**注意**:

- 在 PHP 8.0.0 之前，方括号和花括号可以互换使用来访问数组单元（例如 `$array[42]` 和 `$array{42}` 在上例中效果相同）。
- 花括号语法在 PHP 7.4.0 中已弃用，在 PHP 8.0.0 中不再支持。 

**例子8：数组解引用** 

```php+HTML
<?php
function getArray() {
    return array(1, 2, 3);
}

$secondElement = getArray()[1];

// 或
list(, $secondElement) = getArray();
?>
```

**注意：** 

1. 试图访问一个未定义的数组键名与访问任何未定义变量一样：会导致 **`E_NOTICE`** 级别错误信息，其结果为 **`null`**。
2. 数组解引用非 string 的标量值会产生 **`null`**。
   -  在 PHP 7.4.0 之前，它不会发出错误消息。 
   - 从 PHP 7.4.0 开始，这个问题产生 **`E_NOTICE`** ；
   -  从 PHP 8.0.0 开始，这个问题产生 **`E_WARNING`** 。

#### 2. 方括号新建/修改

可以通过设定其中的值来修改现有的 array 。

这是通过在方括号内指定键名来给 array 赋值实现的。也可以省略键名，在这种情况下给变量名加上一对空的方括号（`[]`）

```php+HTML
$arr[key] = value;
$arr[] = value;
// key 可以是 int 或 string
// value 可以是任意类型的值
```

如果 $arr 不存在，将会新建一个，这也是另一种创建 array 的方法。不过并不鼓励这样做，因为如果 $arr 已经包含有值（例如来自请求变量的 string）则此值会保留而 `[]` 实际上代表着[字符串访问运算符](https://www.php.net/manual/zh/language.types.string.php#language.types.string.substr)。初始化变量的最好方式是直接给其赋值。

- 从 PHP 7.1.0 起，对字符串应用空索引操作符会抛出致命错误。以前，字符串被静默地转换为数组。

要修改某个值，通过其键名给该单元赋一个新值。要删除某键值对，对其调用 [unset()](https://www.php.net/manual/zh/function.unset.php) 函数。

```php
<?php
$arr = array(5 => 1, 12 => 2);

$arr[] = 56;    // 这与 $arr[13] = 56 相同;
                // 在脚本的这一点上

$arr["x"] = 42; // 添加一个新元素
                // 键名使用 "x"
                
unset($arr[5]); // 从数组中删除元素

unset($arr);    // 删除整个数组
?>
```

注意：

- 如上所述，如果给出方括号但没有指定键名，则取当前最大 int 索引值，新的键名将是该值加上 1（但是最小为 0）。如果当前还没有 int 索引，则键名将为 `0` 。
- 这里所使用的最大整数键名*目前不需要存在于 array 中*。 它只要在上次 array 重新生成索引后曾经存在于 array 就行了。以下面的例子来说明：

```php
<?php
// 创建一个简单的数组
$array = array(1, 2, 3, 4, 5);
print_r($array);

// 现在删除其中的所有元素，但保持数组本身不变:
foreach ($array as $i => $value) {
    unset($array[$i]);
}
print_r($array);

// 添加一个单元（注意新的键名是 5，而不是你可能以为的 0）
$array[] = 6;
print_r($array);

// 重新索引：
$array = array_values($array);
$array[] = 7;
print_r($array);
?>
```

输出

```bash
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
)
Array
(
)
Array
(
    [5] => 6
)
Array
(
    [0] => 6
    [1] => 7
)
```

#### 3. 转换为数组

对于任意 int，float， string，bool 和 resource 类型，如果将一个值转换为 array，将得到一个仅有一个元素的数组，其下标为 0，该元素即为此标量的值。换句话说，`(array)$scalarValue` 与 `array($scalarValue)` 完全一样。

如果将 object 类型转换为 array，则结果为一个数组，其单元为该对象的属性。键名将为成员变量名，

不过有几点例外：

- 整数属性不可访问；
- 私有变量前会加上类名作前缀；
- 保护变量前会加上一个 '*' 做前缀。

这些前缀的前后都各有一个 `NUL` 字节。这会导致一些不可预知的行为：

**例子11:** 

```php
<?php

class A {
    private $B;
    protected $C;
    public $D;
    function __construct()
    {
        $this->{1} = null;
    }
}

var_export((array) new A());
?>
```

输出

```bash
array (
  '' . "\0" . 'A' . "\0" . 'B' => NULL,
  '' . "\0" . '*' . "\0" . 'C' => NULL,
  'D' => NULL,
  1 => NULL,
)
```

这些 `NUL` 会导致一些意想不到的行为：

```php
<?php

class A {
    private $A; // 将变为 '\0A\0A'
}

class B extends A {
    private $A; // 将变为 '\0B\0A'
    public $AA; // 将变为 'AA'
}

var_dump((array) new B());
?>
```

```nphp
array(3) {
  ["BA"]=>
  NULL
  ["AA"]=>
  NULL
  ["AA"]=>
  NULL
}
```

上例会有两个键名为 'AA'，不过其中一个实际上是 '\0A\0A'。

将 **`null`** 转换为 array 会得到一个空的数组。

### 实用函数

有很多操作数组的函数，参见 [数组函数](https://www.php.net/manual/zh/ref.array.php) 一节。

注意

- [unset()](https://www.php.net/manual/zh/function.unset.php) 函数允许删除 array 中的某个键。但要注意数组将*不会*重建索引。如果需要删除后重建索引，可以用 [array_values()](https://www.php.net/manual/zh/function.array-values.php) 函数重建 array 索引。

**例子9：c数组重建索引** 

```php
<?php
$a = array(1 => 'one', 2 => 'two', 3 => 'three');
unset($a[2]);
/* 该数组将被定义为
   $a = array(1 => 'one', 3 => 'three');
   而不是
   $a = array(1 => 'one', 2 =>'three');
*/

$b = array_values($a);
// 现在 $b 是 array(0 => 'one', 1 =>'three')
?>
```

[foreach](https://www.php.net/manual/zh/control-structures.foreach.php) 控制结构是专门用于 array的。它提供了一个简单的方法来遍历 array。

#### 2.1 为什么 `$foo[bar]` 错了

应该始终在用字符串表示的数组索引上加上引号。例如用 `$foo['bar']` 而不是 `$foo[bar]`。但是为什么呢？可能在老的脚本中见过如下语法：

```php
<?php
$foo[bar] = 'enemy';
echo $foo[bar];
// 及其它
?>
```

这样是错的，但可以正常运行。

那么为什么错了呢？原因是此代码中有一个未定义的常量（ `bar` ）而不是 string（`'bar'`－注意引号）。而 PHP 可能会在以后定义此常量，不幸的是你的代码中有同样的名字。它能运行，是因为 PHP 自动将*裸字符串*（没有引号的 string 且不对应于任何已知符号）转换成一个其值为该裸 string 的 string。例如，如果没有常量定义为 **`bar`**，那么PHP 将在 string 中替代为 `'bar'` 并使用之。

- 将未定义的常量当作裸字符串的回退会触发 **`E_NOTICE`** 级别错误。 从 PHP 7.2.0 起已废弃，并触发 **`E_WARNING`** 级别错误。 从 PHP 8.0.0 起被移除，并触发 [Error](https://www.php.net/manual/zh/class.error.php) 异常。

**例子10：**

```php+HTML
<?php
// 显示所有错误
error_reporting(E_ALL);

$arr = array('fruit' => 'apple', 'veggie' => 'carrot');

// 正确的
print $arr['fruit'];  // apple
print $arr['veggie']; // carrot

// 不正确的。  这可以工作，但也会抛出一个 E_NOTICE 级别的 PHP 错误，因为
// 未定义名为 apple 的常量
// 
// Notice: Use of undefined constant fruit - assumed 'fruit' in...
print $arr[fruit];    // apple

// 这定义了一个常量来演示正在发生的事情。  值 'veggie'
// 被分配给一个名为 fruit 的常量。
define('fruit', 'veggie');

// 注意这里的区别
print $arr['fruit'];  // apple
print $arr[fruit];    // carrot

// 以下是可以的，因为它在字符串中。
// 不会在字符串中查找常量，因此此处不会出现 E_NOTICE
print "Hello $arr[fruit]";      // Hello apple

// 有一个例外：字符串中花括号围绕的数组中常量可以被解释
//
print "Hello {$arr[fruit]}";    // Hello carrot
print "Hello {$arr['fruit']}";  // Hello apple

// 这将不起作用，并会导致解析错误，例如：
// Parse error: parse error, expecting T_STRING' or T_VARIABLE' or T_NUM_STRING'
// 这当然也适用于在字符串中使用超全局变量
print "Hello $arr['fruit']";
print "Hello $_GET['foo']";

// 串联是另一种选择
print "Hello " . $arr['fruit']; // Hello apple
?>
```

#### 2.2 数组比较

可以用 [array_diff()](https://www.php.net/manual/zh/function.array-diff.php) 函数和 [数组运算符](https://www.php.net/manual/zh/language.operators.array.php) 来比较数组。

**例子12：**

```php
<?php
// This:
$a = array( 'color' => 'red',
            'taste' => 'sweet',
            'shape' => 'round',
            'name'  => 'apple',
            4        // 键名为 0
          );

$b = array('a', 'b', 'c');

// . . .完全等同于:
$a = array();
$a['color'] = 'red';
$a['taste'] = 'sweet';
$a['shape'] = 'round';
$a['name']  = 'apple';
$a[]        = 4;        // 键名为 0

$b = array();
$b[] = 'a';
$b[] = 'b';
$b[] = 'c';

// 执行上述代码后，数组 $a 将是
// array('color' => 'red', 'taste' => 'sweet', 'shape' => 'round', 
// 'name' => 'apple', 0 => 4)， 数组 $b 将是
// array(0 => 'a', 1 => 'b', 2 => 'c'), 或简单的 array('a', 'b', 'c').
?>
```

**例子13：** 

```php+HTML
<?php
$colors = array('red', 'blue', 'green', 'yellow');

foreach ($colors as $color) {
    echo "Do you like $color?\n";
}

?>
```

输出

```php
Do you like red?
Do you like blue?
Do you like green?
Do you like yellow?
```

可以通过引用传递 array 的值来直接更改数组的值。

**例子14：在循环中改变单元** 

```php
<?php
foreach ($colors as &$color) {
    $color = strtoupper($color); // 改为大写
}
unset($color); /* 确保后面对
$color 的写入不会修改最后一个数组元素 */

print_r($colors);
?>
```

输出

```php+HTML
Array
(
    [0] => RED
    [1] => BLUE
    [2] => GREEN
    [3] => YELLOW
)
```

本例生成一个下标从 1 开始的数组。

**例子15： 下标从 1 开始的数组**  

```php+HTML
<?php
$firstquarter  = array(1 => 'January', 'February', 'March');
print_r($firstquarter);
?>
```



相关资料

1. https://www.php.net/manual/zh/language.types.array.php

