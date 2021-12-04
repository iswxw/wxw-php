## 面向对象之函数



### 返回值声明

#### 1.  标量类型声明

默认情况下，所有的 `PHP`  文件都处于弱类型校验模式。

` PHP 7 `增加了标量类型声明的特性，标量类型声明有两种模式:

- 强制模式 (默认)
- 严格模式

标量类型声明语法格式：

```php
declare(strict_types=1); 
```

代码中通过指定 strict_types的值（1或者0），1表示严格类型校验模式，作用于函数调用和返回语句；0表示弱类型校验模式。

```php
可以使用的类型参数有：int、float、bool、string、interfaces、array、callable
```

##### 1.1 强制模式实例

```php+HTML
<?php
// 强制模式
function sum(int ...$ints){
   return array_sum($ints);
}

print(sum(2, '3', 4.1));
?>
```

以上程序执行输出结果为：

```bash
9
```

实例汇总将参数 4.1 转换为整数 4 后再相加。

##### 1.2 严格模式实例

```php+HTML
<?php
// 严格模式
declare(strict_types=1);

function sum(int ...$ints){
   return array_sum($ints);
}

print(sum(2, '3', 4.1));
?>
```

以上程序由于采用了严格模式，所以如果参数中出现不适整数的类型会报错，执行输出结果为：

```bash
PHP Fatal error:  Uncaught TypeError: Argument 2 passed to sum() must be of the type integer, string given, called in……
```

#### 2. 返回值类型声明

`PHP 7`  增加了对返回类型声明的支持，返回类型声明指明了函数返回值的类型。

```php+HTML
可以使用的类型参数有：int、float、bool、string、interfaces、array、callable
```

##### 2.1 返回值类型声明实例

实例中，要求返回结果为整数：

```php+HTML
<?php
declare(strict_types=1);

function returnIntValue(int $value): int {
   return $value;
}

print(returnIntValue(5));
?>
```

以上程序执行输出结果为：

```bash
5
```

##### 2.2 返回值类型声明错误实例

```php+HTML
<?php
declare(strict_types=1);

function returnIntValue(int $value): int {
   return $value + 1.0;
}

print(returnIntValue(5));
?>
```

以上程序由于采用了严格模式，返回值必须是 int，但是计算结果是float，所以会报错，执行输出结果为：

```bash
Fatal error: Uncaught TypeError: Return value of returnIntValue() must be of the type integer, float returned...
```

#### 3. Void 函数

一个新的返回值类型void被引入。 返回值声明为 void 类型的方法要么干脆省去 return 语句，要么使用一个空的 return 语句。

 对于 void 函数来说，NULL 不是一个合法的返回值。返回的类型还有 void，定义返回类型为 void 的函数不能有返回值，即使返回 null 也不行。

void 函数可以省去 return 语句，或者使用一个空的 return 语句。

```php+HTML
<?php
function swap(&$left, &$right) : void
{
    if ($left === $right) {
        return;
    }

    $tmp = $left;
    $left = $right;
    $right = $tmp;
}

$a = 1;
$b = 2;
var_dump(swap($a, $b), $a, $b);
```

以上实例输出结果：

```php
null
int(2)
int(1)
```

相关资料

1. https://www.runoob.com/php/php-scalar-return-type.html

