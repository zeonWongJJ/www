package com.net.rx_retrofit_network.location.callback;


import com.net.rx_retrofit_network.location.model.BaseResponse;

/**
 * Created by baozi on 2017/10/18.
 */

public interface APIExceptionCallBack {
    /**
     * @param baseResponse 网络请求数据
     * @return error 消息
     */
    String callback(BaseResponse baseResponse);
}
