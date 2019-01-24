package app.vdao.qidu.mvp.model;

import android.graphics.BitmapFactory;
import android.text.TextUtils;
import android.util.Log;
import android.widget.Toast;

import com.amap.api.location.AMapLocation;
import com.amap.api.location.AMapLocationClient;
import com.amap.api.location.AMapLocationClientOption;
import com.amap.api.location.AMapLocationListener;
import com.app.base.bean.AppInfo;
import com.app.base.utils.CommonKey;
import com.app.base.utils.HttpLocationByIp;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.NetworkUtil;
import com.common.lib.utils.SharedPreferencesUtils;
import com.net.rx_retrofit_network.location.model.BaseResponse;
import com.net.rx_retrofit_network.location.requestbody.UploadFileRequestBody;
import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;

import org.apache.cordova.api.CallbackContext;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.HashMap;
import java.util.Map;

import app.vdao.qidu.mvp.apiservice.APIService;
import app.vdao.qidu.mvp.apiservice.ApiServcieImpl;
import app.vdao.qidu.mvp.contract.HomeContract;
import io.reactivex.Observable;
import okhttp3.MediaType;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by 7du-28 on 2018/3/13.
 */

public class HomeModeImpl implements HomeContract.Model{

    @Override
    public Observable<AppInfo> checkAppVersion() {
        HashMap<String,String> hashMap=new HashMap<String, String>();
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().checkAppVersion(hashMap));
    }



    //上传头像图片
    /*@Override
    public Observable<String> uploadFiles(String url, HashMap<String, RequestBody> hashMap) {
        return ModelFilterFactory.compose(ApiServcieImpl.getInstance().uploadFiles(url,hashMap));
    }*/


    //上传头像
    public void uploadUserPhoto(String path,Callback callback) {
        String userInfoStr= (String) SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).getData(CommonKey.KEY_LOGIN_USER_INFO,"");
        String userId=null;
        if(TextUtils.isEmpty(userInfoStr)){
            return;
        }
        try {
            JSONObject jsonObject=new JSONObject(userInfoStr);
            if (jsonObject.has("user_id")) {
                userId=jsonObject.getString("user_id");
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        if(userId==null){
            return;
        }
        //showProgressDialog("正在上传,请稍后...");
        APIService service=ApiServcieImpl.getInstance();
        Map<String, RequestBody> map = new HashMap<>();
        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        RequestBody userIdBody = RequestBody.create(
                MediaType.parse("multipart/form-data"),userId);
        map.put("user_id",userIdBody);

        File file = new File(path);//filePath 图片地址
        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(path, options);
        String type = options.outMimeType;
        RequestBody imageBody = RequestBody.create(MediaType.parse(type), file);//multipart/form-data
        UploadFileRequestBody uploadFileRequestBody = new UploadFileRequestBody(imageBody, new UploadFileRequestBody.ProgressRequestListener() {
            @Override
            public void onRequestProgress(long hasWrittenLen, long totalLen, boolean hasFinish) {
                //double r = (double) hasWrittenLen / (double) totalLen;
            }
        });
        //map.put("pic[]", imageBody);//requestBodyMap.put("file\"; filename=\"" + file.getName(), fileRequestBody);
        map.put("user_pic\"; filename=\"" + file.getName(), uploadFileRequestBody);
        Map<String, String> headers=new HashMap<>();
        Call<BaseResponse> resultCall = service.uploadImgPhoto("user_picupload","修改头像",map);

        resultCall.enqueue(callback);
    }

    //定位相关
    private AMapLocationClient locationClient = null;
    private AMapLocationClientOption locationOption = null;
    private CallbackContext callbackLocationContext;
    @Override
    public void startLocationCurrentPosition(CallbackContext callbackContext) {
        this.callbackLocationContext=callbackContext;

        String selectLocationInfo= (String) SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).getData(CommonKey.KEY_SELECT_LOCATION_INFO,"");
        if(!TextUtils.isEmpty(selectLocationInfo)){
            //Log.i("aaaaaaa","============"+selectLocationInfo);
            callbackLocationContext.success(selectLocationInfo);
            return;
        }
        //初始化client
        locationClient = new AMapLocationClient(BaseApplication.getInstance());
        locationOption = getDefaultOption();
        //设置定位参数
        locationClient.setLocationOption(locationOption);
        // 设置定位监听
        locationClient.setLocationListener(locationListener);
        // 启动定位
        locationClient.startLocation();
    }

    @Override
    public void destroyLocation() {
        if (null != locationClient) {
            locationClient.stopLocation();
            /**
             * 如果AMapLocationClient是在当前Activity实例化的，
             * 在Activity的onDestroy中一定要执行AMapLocationClient的onDestroy
             */
            locationClient.onDestroy();
            locationClient = null;
            locationOption = null;
        }
    }



    private AMapLocationClientOption getDefaultOption(){
        AMapLocationClientOption mOption = new AMapLocationClientOption();
        mOption.setLocationMode(AMapLocationClientOption.AMapLocationMode.Hight_Accuracy);//可选，设置定位模式，可选的模式有高精度、仅设备、仅网络。默认为高精度模式
        mOption.setGpsFirst(false);//可选，设置是否gps优先，只在高精度模式下有效。默认关闭
        mOption.setHttpTimeOut(30000);//可选，设置网络请求超时时间。默认为30秒。在仅设备模式下无效
        mOption.setInterval(2000);//可选，设置定位间隔。默认为2秒
        mOption.setNeedAddress(true);//可选，设置是否返回逆地理地址信息。默认是true
        mOption.setOnceLocation(true);//可选，设置是否单次定位。默认是false
        mOption.setOnceLocationLatest(false);//可选，设置是否等待wifi刷新，默认为false.如果设置为true,会自动变为单次定位，持续定位时不要使用
        AMapLocationClientOption.setLocationProtocol(AMapLocationClientOption.AMapLocationProtocol.HTTP);//可选， 设置网络请求的协议。可选HTTP或者HTTPS。默认为HTTP
        mOption.setSensorEnable(false);//可选，设置是否使用传感器。默认是false
        mOption.setWifiScan(true); //可选，设置是否开启wifi扫描。默认为true，如果设置为false会同时停止主动刷新，停止以后完全依赖于系统刷新，定位位置可能存在误差
        mOption.setLocationCacheEnable(true); //可选，设置是否使用缓存定位，默认为true
        return mOption;
    }


    protected void getLocationInfoByIp(){
        new HttpLocationByIp().httpLocationByIp(new HttpLocationByIp.LocationListener() {
            @Override
            public void onSuccess(String response) {
                try {
                    JSONObject object=new JSONObject(response);
                    if(object.getString("status").equals("1")){
                        final JSONObject jsonObject=new JSONObject();
                        try {
                            jsonObject.put("provinceName",jsonObject.getString("province"));
                            jsonObject.put("cityName",jsonObject.getString("city"));
                            jsonObject.put("cityCode","");
                            jsonObject.put("adCode",jsonObject.getString("adcode"));
                            jsonObject.put("direction","");
                            jsonObject.put("snippet","");
                            jsonObject.put("title","");
                            jsonObject.put("latitude","");
                            jsonObject.put("longitude","");
                            jsonObject.put("address","");
                            if(callbackLocationContext!=null){
                                SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).saveData(CommonKey.KEY_SELECT_LOCATION_INFO,jsonObject.toString());
                                callbackLocationContext.success(jsonObject.toString());
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }else {
                        if(callbackLocationContext!=null){
                            callbackLocationContext.error("定位失败");
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onError(String error) {
                if(callbackLocationContext!=null){
                    callbackLocationContext.error("定位失败");
                }
            }
        });


    }

    /**
     * 定位监听
     */
    AMapLocationListener locationListener = new AMapLocationListener() {
        @Override
        public void onLocationChanged(AMapLocation location) {
            if (null != location) {
                //errCode等于0代表定位成功，其他的为定位失败，具体的可以参照官网定位错误码说明
                if(location.getErrorCode() == 0){
                    //定位完成的时间
                    //sb.append("定位时间: " + Utils.formatUTC(location.getTime(), "yyyy-MM-dd HH:mm:ss") + "\n");
                    destroyLocation();
                    //final String str=location.getProvince()+location.getCity()+location.getDistrict()+location.getAddress();
                    //Toast.makeText(getActivity(),str,Toast.LENGTH_SHORT).show();
                    final JSONObject jsonObject=new JSONObject();
                    try {
                        jsonObject.put("provinceName",location.getProvince());
                        jsonObject.put("cityName",location.getCity());
                        jsonObject.put("cityCode",location.getCityCode());
                        jsonObject.put("adCode",location.getAdCode());
                        //jsonObject.put("direction",location.getDistrict()+"");
                        jsonObject.put("direction",location.getDistrict()+"");
                        jsonObject.put("snippet",location.getStreet()+""+location.getStreetNum());
                        jsonObject.put("title",location.getDescription()+"");
                        jsonObject.put("latitude",location.getLatitude());
                        jsonObject.put("longitude",location.getLongitude());
                        jsonObject.put("address",location.getAddress());

                        //Log.i("aaaaaaa",location.getLocationDetail()+"getBuildingId=="+location.getBuildingId()+"getBearing=="+location.getBearing()+"getDescription"+location.getDescription()+"getStreet"+location.getStreet()+"getStreetNum"+location.getStreetNum());
                        ///getAddress  广东省广州市番禺区福怡路17号靠近长华创意谷
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    if(callbackLocationContext!=null){
                        SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).saveData(CommonKey.KEY_SELECT_LOCATION_INFO,jsonObject.toString());
                        callbackLocationContext.success(jsonObject.toString());
                    }
                } else {

                    if(NetworkUtil.isWifi(BaseApplication.getInstance())){
                        if(callbackLocationContext!=null){
                            callbackLocationContext.error("定位失败");
                        }
                    }else {
                        getLocationInfoByIp();
                    }
                    //定位失败
                    /*sb.append("定位失败" + "\n");
                    sb.append("错误码:" + location.getErrorCode() + "\n");
                    sb.append("错误信息:" + location.getErrorInfo() + "\n");
                    sb.append("错误描述:" + location.getLocationDetail() + "\n");*/
                }
                //解析定位结果，
                //String result = sb.toString();
            } else {
                //tvResult.setText("定位失败，loc is null");
            }
        }
    };
}
