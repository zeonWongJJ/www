package com.app.base.utils;

import java.text.DecimalFormat;

/**
 * Created by 7du-28 on 2017/8/24.
 */

public class DataUtils {
    public static final String WECHAT_APP_ID="wxeabc8436ab550bc3";

    public static final String WECHAT_SECRET_ID="ca9c7837e87471f29972dd99164c1a08";

    /**
     * 将每三个数字加上逗号处理（通常使用金额方面的编辑）
     *
     * @param str 需要处理的字符串
     * @return 处理完之后的字符串
     */
    public static String addComma(String str) {
        DecimalFormat decimalFormat = new DecimalFormat(",###");
        return decimalFormat.format(Double.parseDouble(str));
    }

}
