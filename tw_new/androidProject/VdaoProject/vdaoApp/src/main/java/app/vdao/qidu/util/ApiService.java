package app.vdao.qidu.util;

import com.gzqx.common.httpbase.net.BaseResponse;

import java.util.Map;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.PartMap;

/**
 * Created by 7du-28 on 2017/6/29.
 */

public interface ApiService {
    @Multipart
    @POST("add_index")
    Call<String> uploadImage(@Part MultipartBody.Part file);


    @Multipart
    //@Headers("{Headers}")
    @POST("user_picupload")
    Call<BaseResponse> uploadFiles(
            /*@Path("url") String url,*/
            /*@Path("headers") Map<String, String> headers,*/
            @Part("description") String description,//文件描述
            @PartMap() Map<String, RequestBody> maps);

    @Multipart
    //@Headers("{Headers}")
    @POST("join_upload")
    Call<BaseResponse> uploadCredentialsPic(
            /*@Path("url") String url,*/
            /*@Path("headers") Map<String, String> headers,*/
            @Part("description") String description,//文件描述
            @PartMap() Map<String, RequestBody> maps);
}
