## PHP 流程控制

任何 PHP 脚本都是由一系列语句构成的。一条语句可以是一个赋值语句，一个函数调用，一个循环，一个条件语句或者甚至是一个什么也不做的语句（空语句）。语句通常以分号结束。此外，还可以用花括号将一组语句封装成一个语句组。语句组本身可以当作是一行语句。本章介绍了各种语句类型。

### 控制函数

#### 1. for

`for` 循环是 PHP 中最复杂的循环结构。它的行为和 C 语言的相似。 `for` 循环的语法是：

```php
for (expr1; expr2; expr3)
    statement
```

- expr1在循环开始前无条件求值（并执行）一次。

- expr2 在每次循环开始前求值。如果值为 **`true`**，则继续循环，执行嵌套的循环语句。如果值为 **`false`**，则终止循环。

- expr3 在每次循环之后被求值（并执行）。

**例子1：**

```php+HTML
<?php
/* 示例 1 */

for ($i = 1; $i <= 10; $i++) {
    echo $i;
}

/* 示例 2 */

for ($i = 1; ; $i++) {
    if ($i > 10) {
        break;
    }
    echo $i;
}

/* 示例 3 */

$i = 1;
for (;;) {
    if ($i > 10) {
        break;
    }
    echo $i;
    $i++;
}

/* 示例 4 */

for ($i = 1, $j = 0; $i <= 10; $j += $i, print $i, $i++);
?>
```

**例子2：**

```php+HTML
<?php
/*
 * 此数组将在遍历的过程中改变其中某些单元的值
 */
$people = Array(
        Array('name' => 'Kalle', 'salt' => 856412), 
        Array('name' => 'Pierre', 'salt' => 215863)
        );

for($i = 0; $i < count($people); ++$i)
{
    $people[$i]['salt'] = rand(000000, 999999);
}
?>

以上代码可能执行很慢，因为每次循环时都要计算一遍数组的长度。由于数组的长度始终不变，可以用一个中间变量来储存数组长度以优化而不是不停调用 count()：
<?php
$people = Array(
        Array('name' => 'Kalle', 'salt' => 856412), 
        Array('name' => 'Pierre', 'salt' => 215863)
        );

for($i = 0, $size = count($people); $i < $size; ++$i)
{
    $people[$i]['salt'] = rand(000000, 999999);
}
?>
```

#### 2. foreach

`foreach` 仅能够应用于数组和对象，如果尝试应用于其他数据类型的变量，或者未初始化的变量将发出错误信息。有两种语法：

```
foreach (iterable_expression as $value)
    statement
    

foreach (iterable_expression as $key => $value)
    statement
```

- 第一种格式遍历给定的 `iterable_expression` 迭代器。每次循环中，当前单元的值被赋给 `$value`。
- 第二种格式做同样的事，只除了当前单元的键名也会在每次循环中被赋给变量 `$key`。

注意 `foreach` 不会修改类似 [current()](https://www.php.net/manual/zh/function.current.php) 和 [key()](https://www.php.net/manual/zh/function.key.php) 函数所使用的数组内部指针。



可以很容易地通过在 `$value` 之前加上 & 来修改数组的元素。此方法将以[引用](https://www.php.net/manual/zh/language.references.php)赋值而不是拷贝一个值。

```php+HTML
<?php
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
// 现在 $arr 是 array(2, 4, 6, 8)
unset($value); // 最后取消掉引用
?>
```

**数组最后一个元素的 `$value` 引用在 `foreach` 循环之后仍会保留。建议使用 [unset()](https://www.php.net/manual/zh/function.unset.php) 来将其销毁。 否则你会遇到下面的情况：** 

````php+HTML
<?php
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
// 现在 $arr 是 array(2, 4, 6, 8)

// 未使用 unset($value) 时，$value 仍然引用到最后一项 $arr[3]

foreach ($arr as $key => $value) {
    // $arr[3] 会被 $arr 的每一项值更新掉…
    echo "{$key} => {$value} ";
    print_r($arr);
}
// 直到最终倒数第二个值被复制到最后一个值

// output:
// 0 => 2 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 2 )
// 1 => 4 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 4 )
// 2 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )
// 3 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )
?>
````

可以通过引用来遍历数组常量的值：

```php
<?php
foreach (array(1, 2, 3, 4) as &$value) {
    $value = $value * 2;
}
?>
```

**例子3** 

```php+HTML
<?php
/* foreach 示例 1：仅 value */

$a = array(1, 2, 3, 17);

foreach ($a as $v) {
   echo "Current value of \$a: $v.\n";
}

/* foreach 示例 2：value (with its manual access notation printed for illustration) */

$a = array(1, 2, 3, 17);

$i = 0; /* 仅供说明 */

foreach ($a as $v) {
    echo "\$a[$i] => $v.\n";
    $i++;
}

/* foreach 示例 3：key 和 value */

$a = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "seventeen" => 17
);

foreach ($a as $k => $v) {
    echo "\$a[$k] => $v.\n";
}

/* foreach 示例 4：多维数组 */
$a = array();
$a[0][0] = "a";
$a[0][1] = "b";
$a[1][0] = "y";
$a[1][1] = "z";

foreach ($a as $v1) {
    foreach ($v1 as $v2) {
        echo "$v2\n";
    }
}

/* foreach 示例 5：动态数组 */

foreach (array(1, 2, 3, 4, 5) as $v) {
    echo "$v\n";
}
?>
```

**用list() 给嵌套的数组解包** 

可以遍历一个数组的数组并且把嵌套的数组解包到循环变量中，只需将 [list()](https://www.php.net/manual/zh/function.list.php) 作为值提供。

**例子4**

```php+HTML
<?php
$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b)) {
    // $a 包含嵌套数组的第一个元素，
    // $b 包含嵌套数组的第二个元素。
    echo "A: $a; B: $b\n";
}
?>
```

以上例程会输出：

```
A: 1; B: 2
A: 3; B: 4
```

[list()](https://www.php.net/manual/zh/function.list.php) 中的单元可以少于嵌套数组的，此时多出来的数组单元将被忽略：

```php+HTML
<?php
$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a)) {
    // 注意这里没有 $b。
    echo "$a\n";
}
?>
```

以上例程会输出：

```
1
3
```

如果 [list()](https://www.php.net/manual/zh/function.list.php) 中列出的单元多于嵌套数组则会发出一条消息级别的错误信息：

```
<?php
$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b, $c)) {
    echo "A: $a; B: $b; C: $c\n";
}
?>
```

以上例程会输出：

```
Notice: Undefined offset: 2 in example.php on line 7
A: 1; B: 2; C: 

Notice: Undefined offset: 2 in example.php on line 7
A: 3; B: 4; C: 
```

#### 3. list()

list — 把数组中的值赋给一组变量

用法：

```php+HTML
list(mixed $var, mixed ...$vars = ?): array

- var：一个变量。
- vars：更多变量。
- 返回指定数组
```

像 [array()](https://www.php.net/manual/zh/function.array.php) 一样，这不是真正的函数，而是语言结构。 **list()** 可以在单次操作内就为一组变量赋值。

**注意：** 

- PHP 5 里，**list()** 从最右边的参数开始赋值； PHP 7 里，**list()** 从最左边的参数开始赋值。
- 如果你用单纯的变量，不用担心这一点。 但是如果你用了具有索引的数组，通常你期望得到的结果和在 **list()** 中写的一样是从左到右的，但在 PHP 5 里实际上不是， 它是以相反顺序赋值的。

**例子1：** 

```php+HTML
<?php

$info = array('coffee', 'brown', 'caffeine');

// 列出所有变量
list($drink, $color, $power) = $info;
echo "$drink is $color and $power makes it special.\n";

// 列出他们的其中一个
list($drink, , $power) = $info;
echo "$drink has $power.\n";

// 或者让我们跳到仅第三个
list( , , $power) = $info;
echo "I need $power!\n";

// list() 不能对字符串起作用
list($bar) = "abcde";
var_dump($bar); // NULL
?>
```

**例子2：用法** 

```php+HTML
<table>
 <tr>
  <th>Employee name</th>
  <th>Salary</th>
 </tr>

<?php

$result = $pdo->query("SELECT id, name, salary FROM employees");
while (list($id, $name, $salary) = $result->fetch(PDO::FETCH_NUM)) {
    echo " <tr>\n" .
          "  <td><a href=\"info.php?id=$id\">$name</a></td>\n" .
          "  <td>$salary</td>\n" .
          " </tr>\n";
}
?>

</table>
```

**例子3：嵌套list** 

```php+HTML
<?php

list($a, list($b, $c)) = array(1, array(2, 3));

var_dump($a, $b, $c);

?>
输出
int(1)
int(2)
int(3)
```

**例子4：list中使用数组索引** 

```php
<?php

$info = array('coffee', 'brown', 'caffeine');

list($a[0], $a[1], $a[2]) = $info;

var_dump($a);

?>
```

产生如下输出（注意单元顺序和 **list()** 语法中所写的顺序的比较）：

以上例程在 PHP 7 中的输出：

```ba
array(3) {
  [0]=>
  string(6) "coffee"
  [1]=>
  string(5) "brown"
  [2]=>
  string(8) "caffeine"
}
```

以上例程在 PHP 5 中的输出：

```
array(3) {
  [2]=>
  string(8) "caffeine"
  [1]=>
  string(5) "brown"
  [0]=>
  string(6) "coffee"
}
```

**例子5：带key的list** 

从 PHP 7.1.0 开始，**list()** 可以包含显式的键，可赋值到任意表达式。 可以混合使用数字和字符串键。但是不能混合有键和无键不能混用。

```php+HTML
<?php
$data = [
    ["id" => 1, "name" => 'Tom'],
    ["id" => 2, "name" => 'Fred'],
];
foreach ($data as ["id" => $id, "name" => $name]) {
    echo "id: $id, name: $name\n";
}
echo PHP_EOL;
list(1 => $second, 3 => $fourth) = [1, 2, 3, 4];
echo "$second, $fourth\n";
```

以上例程会输出：

```
id: 1, name: Tom
id: 2, name: Fred

2, 4
```

#### 4. match

`match` 表达式基于值的一致性进行分支计算。 `match`表达式和 `switch` 语句类似， 都有一个表达式主体，可以和多个可选项进行比较。 与 `switch` 不同点是，它会像三元表达式一样求值。 与 `switch` 另一个不同点，它的比较是严格比较（ `===`）而不是松散比较（`==`）。 Match 表达式从 PHP 8.0.0 起可用。

**基础用法** 

```php+HTML
<?php
$food = 'cake';

$return_value = match ($food) {
    'apple' => 'This food is an apple',
    'bar' => 'This food is a bar',
    'cake' => 'This food is a cake',
};

var_dump($return_value);
?>
```

以上例程会输出：

```
string(19) "This food is a cake"
```



相关资料

1. https://www.php.net/manual/zh/language.control-structures.php