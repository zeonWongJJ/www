package com.gzqx.common.httpbase.net;

import com.gzqx.common.bean.AppInfo;
import com.gzqx.common.bean.IpResult;
import com.gzqx.common.bean.Store;

import java.util.List;
import java.util.Map;

import io.reactivex.Observable;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.PartMap;
import retrofit2.http.Path;
import retrofit2.http.Query;
import retrofit2.http.QueryMap;
import retrofit2.http.Streaming;
import retrofit2.http.Url;


public interface BaseApiService {

    public static final String Base_URL = "http://vdao_mobile.7dugo.com/";
    /**
     *普通写法
     */
    @GET("service/getIpInfo.php")
    Observable<BaseResponse<IpResult>> getData(@Query("ip") String ip);

    @GET("v3/ip")
    Call<ResponseBody> getLocationInfoByIp(
            @QueryMap Map<String, String> maps
    );

    @GET("{url}")
     Observable<BaseResponse<List<Store>>> executeGet(
            @Path("url") String url,
            @QueryMap Map<String, String> maps
    );

    @GET("{url}")
    Observable<BaseResponse<AppInfo>> executeGetAppInfo(
            @Path("url") String url,
            @QueryMap Map<String, String> maps
    );

    @POST("{url}")
    Observable<ResponseBody> executePost(
            @Path("url") String url,
            //  @Header("") String authorization,
            @QueryMap Map<String, String> maps);

    @POST("{url}")
    Observable<ResponseBody> json(
            @Path("url") String url,
            @Body RequestBody jsonStr);

    //单文件上传
    @Multipart
    @POST("{url}")
    Observable<ResponseBody> upLoadFile(
            @Path("url") String url,
            @Part("image\"; filename=\"image.jpg") RequestBody requestBody);

    /*
    @Multipart
    @POST("{url}")
    Call<ResponseBody> uploadFiles(
            @Path("url") String url,
            @Path("headers") Map<String, String> headers,
            @Part("filename") String description,
            @PartMap() Map<String, RequestBody> maps);*/

    /*RequestBody description =
        RequestBody.create(
                MediaType.parse("multipart/form-data"), descriptionString);*/
    @Multipart
    @POST("{url}")
    Observable<ResponseBody> uploadFiles(
            @Path("url") String url,
            //@Path("headers") Map<String, String> headers,
            @Part("description") String description,//文件描述
            @PartMap() Map<String, RequestBody> maps);

    @Streaming
    @GET
    Observable<ResponseBody> downloadFile(@Url String fileUrl);


    /*@POST("")
    Call<ResponseBody> prepayIdTask(@M);*/
}
