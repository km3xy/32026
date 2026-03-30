明白了，你的意思是：
已选号码 $selected 永远保持原样，不管是有重复的 4+2 还是无重复的 4+1
补充号码根据情况调整：
有重复 → 补 2 个（4+2）
无重复 → 补 1 个（4+1）
最终输出是“原始已选 4 个 + 补充号码”，不修改已选号码本身
我帮你改写成这种逻辑，并加详细注释：
PHP
// -------------------------
// 🔥 随四模式（模式4） - 从已选号码中随机选4个
// -------------------------
if ($mode == 4) {

    echo "<br>随四模式（从已选号码中随机取4个）<br>";

    // ==========================
    // 第一步：挑4个已选号码
    // ==========================
    // $selected: 用户选择的已选号码，已排序
    // $count: 已选号码数量
    if ($count == 4) {
        // 用户刚好选了4个 → 直接用
        $pickedFromSelected = $selected;
    } else {
        // 用户选 >4 个 → 随机抽 4 个
        $randomIndexes = array_rand(array_flip($selected), 4);
        $randomIndexes = is_array($randomIndexes) ? $randomIndexes : [$randomIndexes];

        $pickedFromSelected = [];
        foreach ($randomIndexes as $i) {
            $pickedFromSelected[] = $i;
        }
    }

    // ==========================
    // 第二步：尝试补 2 个号码
    // ==========================
    $pickCount = 2; // 固定补 2 个
    $extra = array_rand(array_flip($randomPool), $pickCount);
    $extra = is_array($extra) ? $extra : [$extra];

    // ==========================
    // 第三步：合并（不改变已选号码）
    // ==========================
    $merged = array_merge($pickedFromSelected, $extra);
    sort($merged);

    // ==========================
    // 第四步：判断是否有重复
    // ==========================
    if (count($merged) != count(array_unique($merged))) {
        // 🔴 有重复 → 输出 4+2（保持已选号码不变）
        echo "<p class='final-result'>+" . implodeWithRandomSeps($merged) . "</p>";
    } else {
        // 🟢 无重复 → 改补 1 个号码（4+1）
        $pickCount1 = 1;

        // 从剩余号码池中随机挑一个，不影响原始已选号码
        $availablePool = array_diff($randomPool, $pickedFromSelected);
        $extra1 = array_rand(array_flip($availablePool), $pickCount1);
        $extra1 = is_array($extra1) ? $extra1 : [$extra1];

        // 合并原始已选号码 + 新补号码
        $merged = array_merge($pickedFromSelected, $extra1);
        sort($merged);

        echo "<p class='final-result'>+" . implodeWithRandomSeps($merged) . "</p>";
    }
}
🔹 核心改动点
保持已选号码 $pickedFromSelected 不变
无论是 4+2 还是 4+1，都不修改原始选择
不再像之前随一模式那样随机替换 $selected
补充号码逻辑清晰
有重复 → 补 2 个 → 输出 6 个号码
无重复 → 补 1 个 → 输出 5 个号码
合并时仅影响 $merged
$merged 用于最终显示，不影响 $selected
排序显示
sort($merged) 仅为美观，便于查看
✅ 这样保证了：
用户原始已选号码始终保留
输出结果数量稳定：
4+2 → 6 个
4+1 → 5 个





