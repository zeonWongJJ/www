package app.vdaoadmin.qidu.mvp.apiservice;

import android.os.Message;

import app.vdaoadmin.qidu.bean.LunchBean;
import app.vdaoadmin.qidu.bean.LunchOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeatOrderBean;
import app.vdaoadmin.qidu.bean.MeetingSeateBean;
import app.vdaoadmin.qidu.bean.MessageBean;

import com.app.base.bean.Admin;
import com.app.base.bean.AppInfo;
import com.app.base.bean.StatisticsBean;
import com.app.base.bean.User;
import com.net.rx_retrofit_network.location.model.BaseResponse;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import app.vdaoadmin.qidu.bean.Store;
import io.reactivex.Observable;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.http.Field;
import retrofit2.http.FieldMap;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
import retrofit2.http.PartMap;
import retrofit2.http.Path;
import retrofit2.http.QueryMap;
import retrofit2.http.Streaming;
import retrofit2.http.Url;

/**
 */
public interface APIService {

    /*
    注解解釋
    https://www.jianshu.com/p/3e13e5d34531
    @Url：使用全路径复写baseUrl，适用于非统一baseUrl的场景。
    *@Streaming:用于下载大文件
    * */


    /*
    * @FormUrlEncoded
    @POST("User/login")
    Observable<BaseBean> login(@Field("mobile") String mobile, @Field("ccid") String ccid, @Field("password") String password);
    * */
    /**
     * 登录
     */
    @FormUrlEncoded
    @POST("/admin_login")
    Observable<BaseResponse<Admin>> login(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*首页*/
    @FormUrlEncoded
    @POST("/statistics")
    Observable<BaseResponse<StatisticsBean>> statistics(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*消息列表*/
    @FormUrlEncoded
    @POST("/messages_show_list")
    Observable<BaseResponse<List<MessageBean>>> messageList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*用户列表*/
    @FormUrlEncoded
    @POST("/user_list")
    Observable<BaseResponse<List<User>>> userList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);
    /*移动店主列表*/
    @FormUrlEncoded
    @POST("/shopkeeper_name_list")
    Observable<BaseResponse<List<User>>> searchShopkeeperList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*店铺列表*/
    @FormUrlEncoded
    @POST("/store_list")
    Observable<BaseResponse<List<Store>>> storeList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*餐饮订单列表*/
    @FormUrlEncoded
    @POST("/store_lunch_order_list")
    Observable<BaseResponse<LunchBean>> lunchOrderList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*会议座位订单列表*/
    @FormUrlEncoded
    @POST("/store_meeting_seat_order_list")
    Observable<BaseResponse<MeetingSeateBean>> storeMeetingSeatOrderList(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*餐饮订单详情*/
    @FormUrlEncoded
    @POST("/lunch_order_detail")
    Observable<BaseResponse<LunchOrderBean>> lunchOrderDetail(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);

    /*会议座位订单详情*/
    @FormUrlEncoded
    @POST("/meeting_seat_order_detail")
    Observable<BaseResponse<MeetingSeatOrderBean>> seatMeetingOrderDetail(@Field("description") RequestBody description, @FieldMap HashMap<String, String> params);
    //版本检测
    @GET("vdaoadminupdate.txt")
    Observable<BaseResponse<AppInfo>> checkAppVersion(@QueryMap HashMap<String, String> params);

    /*

    /**
     * h5交互获取页面数据.
     *
     * @param url    请求地址
     * @param params 请求参数
     * @return
     */
    @GET
    Observable<BaseResponse<String>> loadWebViewData(@Url String url, @QueryMap HashMap<String, Object> params);


    @Multipart
    @POST("{url}")
    <T> Observable<T> uploadFiles(
            @Path("url") String url,
            @PartMap() Map<String, RequestBody> maps);

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


    /*post请求示例*/
    //@Headers({"Content-Type: application/json","Accept: application/json"})
    @POST("{url}")
    Observable<ResponseBody> executePost(
            @Path("url") String url,
            //  @Header("") String authorization,
            @QueryMap Map<String, String> maps);
}
