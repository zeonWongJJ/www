package com.app.base.utils;


import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;

public class HttpUrl {

    public static String DEFAULT_HOST= RetrofitUtil.DEFAULT_HOST;


    public static String homeUrl=DEFAULT_HOST;//首页地址

    public static String foundUrl=DEFAULT_HOST+"product_category";//发现地址

    public static String shoppingCarUrl=DEFAULT_HOST+"shopping";//购物车地址

    public static String showListUrl=DEFAULT_HOST+"mood_showlist";//动态

    public static String userCenterUrl=DEFAULT_HOST+"user_center";//个人中心

    public static String apkUrl=DEFAULT_HOST+"vdao.apk";
    //http://hengdawb-app.oss-cn-hangzhou.aliyuncs.com/app-debug.apk


}
