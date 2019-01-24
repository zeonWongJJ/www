package app.vdao.qidu.mvp.apiservice;


import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;
import retrofit2.http.Query;
import retrofit2.http.QueryMap;

/**
 * Created by 7du-28 on 2017/12/19.
 */

public interface WXLoginService {

    /*接口说明
    通过code获取access_token的接口。*/
    @GET("/sns/oauth2/access_token")
    Call<ResponseBody> getAccessTokenData(@Query("appid") String appid, @Query("secret") String secret, @Query("code") String code, @Query("grant_type") String grant_type);


    @GET("/sns/userinfo")
    Call<ResponseBody> getUserData(@Query("access_token") String access_token, @Query("openid") String openid);
}
