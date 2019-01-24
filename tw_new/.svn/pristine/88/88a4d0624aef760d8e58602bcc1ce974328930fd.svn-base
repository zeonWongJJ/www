package app.vdao.qidu.activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.widget.Toast;

import com.amap.api.location.AMapLocation;
import com.amap.api.location.AMapLocationClient;
import com.amap.api.location.AMapLocationClientOption;
import com.amap.api.location.AMapLocationListener;
import com.gzqx.common.datautil.SharedPreferencesUtils;
import com.gzqx.common.httpbase.net.BaseResponse;
import com.gzqx.common.httpbase.net.NetworkUtil;
import com.gzqx.common.httpbase.net.RetrofitClient;
import com.gzqx.common.httpbase.net.UploadFileRequestBody;
import com.gzqx.common.utils.CommonKey;
import com.gzqx.common.utils.DataUtils;
import com.gzqx.common.utils.IntentParams;
import com.gzqx.common.webview.CordovaWebActivity;
import com.liang.scancode.utils.Constant;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.compress.Luban;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.tencent.mm.opensdk.modelmsg.SendAuth;
import com.tencent.mm.opensdk.openapi.IWXAPI;
import com.tencent.mm.opensdk.openapi.WXAPIFactory;

import org.apache.cordova.api.CallbackContext;
import org.json.JSONException;
import org.json.JSONObject;
import app.vdao.qidu.AppApplication;

import app.vdao.qidu.R;
import app.vdao.qidu.util.ApiService;
import app.vdao.qidu.util.HttpLocationByIp;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import okhttp3.MediaType;
import okhttp3.RequestBody;
import retrofit2.Call;

import retrofit2.Callback;
import retrofit2.Response;


public abstract class BasePhotoSelectActivity extends CordovaWebActivity {
    public static final String TAG = "MainActivity";
    private int selectMode = PictureConfig.MULTIPLE;
    private int maxSelectNum = 9;// 图片最大可选数量
    protected boolean isShow = true;
    /*protected int selectType = FunctionConfig.TYPE_IMAGE;
    protected int copyMode = FunctionConfig.CROP_MODEL_DEFAULT;*/
    protected boolean enablePreview = true;
    protected boolean isPreviewVideo = true;
    protected boolean enableCrop = true;
    protected boolean theme = false;
    protected boolean selectImageType = false;
    protected int cropW = 0;
    protected int cropH = 0;
    protected int maxB = 0;
    protected int compressW = 0;
    protected int compressH = 0;
    protected boolean isCompress = false;
    protected boolean isCheckNumMode = false;
    protected int compressFlag = 1;// 1 系统自带压缩 2 luban压缩
    protected List<LocalMedia> selectMedia = new ArrayList<>();
    protected int themeStyle;
    protected int previewColor, completeColor, previewBottomBgColor, previewTopBgColor, bottomBgColor, checkedBoxDrawable;
    protected boolean mode = false;// 启动相册模式
    protected boolean clickVideo = false;
    protected boolean isCircle=false;
    protected int maxVideoSeconds=30;//限制和选择视频的最大时长 秒
    protected int aspect_ratio_x=1,aspect_ratio_y=1;
    private int chooseMode = PictureMimeType.ofAll();
    public CallbackContext callbackContext;

    public CallbackContext callbackLocationContext;


    BroadcastReceiver broadcastReceiver =new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String action=intent.getAction();
            if(action.equals(IntentParams.ACTION_GET_USER_INFO_BY_WX_LOGIN)){
                if(callbackContext!=null){
                    String response=intent.getStringExtra(IntentParams.KEY_USER_INFO_BY_WX_LOGIN);
                    callbackContext.success(response);
                }
            }
        }
    };

    private AMapLocationClient locationClient = null;
    private AMapLocationClientOption locationOption = null;
    //开始定位
    public void startLocation(CallbackContext callbackContext){
        this.callbackLocationContext=callbackContext;

        String selectLocationInfo= (String) SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_SELECT_LOCATION_INFO,"");
        if(!TextUtils.isEmpty(selectLocationInfo)){
            //Log.i("aaaaaaa","============"+selectLocationInfo);
            callbackLocationContext.success(selectLocationInfo);
            return;
        }
        //初始化client
        locationClient = new AMapLocationClient(getActivity().getApplicationContext());
        locationOption = getDefaultOption();
        //设置定位参数
        locationClient.setLocationOption(locationOption);
        // 设置定位监听
        locationClient.setLocationListener(locationListener);
        // 启动定位
        locationClient.startLocation();
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
                                SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_SELECT_LOCATION_INFO,jsonObject.toString());
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
        /*OkHttpClient okHttpClient = new OkHttpClient.Builder()
                .addNetworkInterceptor(
                        new HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY))
                .cookieJar(new NovateCookieManger(getActivity()))

                .addInterceptor(new BaseInterceptor(null))
                .addInterceptor(new CaheInterceptor(getActivity()))
                .addNetworkInterceptor(new CaheInterceptor(getActivity()))

                .connectionPool(new ConnectionPool(8, 15, TimeUnit.SECONDS))
                // 这里你可以根据自己的机型设置同时连接的个数和时间，我这里8个，和每个保持时间为10s
                .build();
        Map<String, String> maps = new HashMap<String, String>();
        maps.put("ip",NetworkUtil.getLocalIpAddress());
        maps.put("key","96089bf909fc81e44d2004b1978f8c47");
        Retrofit retrofit = new Retrofit.Builder()
                .client(okHttpClient)
                .addConverterFactory(GsonConverterFactory.create())
                .addCallAdapterFactory(RxJava2CallAdapterFactory.create())
                .baseUrl("http://restapi.amap.com/")
                .build();
        BaseApiService service = retrofit.create(BaseApiService.class);
        Call<ResponseBody> call=service.getLocationInfoByIp(maps);
        Log.i(TAG,NetworkUtil.getLocalIpAddress()+"=======");
        call.enqueue(new Callback<ResponseBody>() {
            @Override
            public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
                Log.i(TAG,"======================"+ response.isSuccessful()+response.message()+"    "+response.code()+"   "+response.body());
                try {
                    Log.i(TAG, response.isSuccessful()+response.message()+"    "+response.code()+"   "+response.body());
                    String result = response.body().string();
                    Log.i(TAG,result+"");

                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            @Override
            public void onFailure(Call<ResponseBody> call, Throwable t) {
                Log.i(TAG, t.getMessage());
            }
        });*/

    }
    private void destroyLocation(){
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
                        SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_SELECT_LOCATION_INFO,jsonObject.toString());
                        callbackLocationContext.success(jsonObject.toString());
                    }
                } else {

                    if(NetworkUtil.isWifi(getActivity())){
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
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        super.initViewsAndEvents(savedInstanceState);
        IntentFilter intentFilter = new IntentFilter();
        intentFilter.addAction(IntentParams.ACTION_GET_USER_INFO_BY_WX_LOGIN);
        registerReceiver(broadcastReceiver, intentFilter);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        destroyLocation();
        unregisterReceiver(broadcastReceiver);
    }
    //二维码条形码扫描
    public void qrCodeScan(CallbackContext callbackContext,int qrCodeType){
        this.callbackContext=callbackContext;
        Intent intent=new Intent(getActivity(),QRCodeScanActivity.class);
        if(qrCodeType==1){
            intent.putExtra(Constant.REQUEST_SCAN_MODE,Constant.REQUEST_SCAN_MODE_QRCODE_MODE);//二维码
        }else if(qrCodeType==2){
            intent.putExtra(Constant.REQUEST_SCAN_MODE,Constant.REQUEST_SCAN_MODE_BARCODE_MODE);//条形码
        }else {
            intent.putExtra(Constant.REQUEST_SCAN_MODE, Constant.REQUEST_SCAN_MODE_ALL_MODE);
        }
        startActivityForResult(intent,QRCodeScanActivity.QR_REQUEST_CODE);
    }

    //证件上传
    public void credentialsUpload(CallbackContext callbackContext,int type,String business_license_url,String identity_positive_url,String identity_native_url){
        this.callbackContext=callbackContext;
        Intent intent=new Intent(getActivity(),CredentialsUploadActivity.class);
        intent.putExtra(IntentParams.KEY_CREDENTIALS_TYPE,type);
        intent.putExtra(IntentParams.KEY_BUSINESS_LICENSE_URL,business_license_url);
        intent.putExtra(IntentParams.KEY_IDENTITY_POSITIVE_URL,identity_positive_url);
        intent.putExtra(IntentParams.KEY_IDENTITY_NATIVE_URL,identity_native_url);
        startActivityForResult(intent,CredentialsUploadActivity.CREDENTIALS_REQUEST_CODE);
    }


    private boolean isAddressUseForHomePage;
    public void addressLocation(CallbackContext callbackContext,boolean isAddressUseForHomePage){
        this.callbackContext=callbackContext;
        this.isAddressUseForHomePage=isAddressUseForHomePage;
        Intent intent=new Intent(getActivity(),SearchAddressByMapPoiActivity.class);
        startActivityForResult(intent,0x789);
    }
    /*授权登录*/
    public void WXLogin(CallbackContext callbackContext){
        this.callbackContext=callbackContext;
        IWXAPI api = WXAPIFactory.createWXAPI(getActivity(), DataUtils.WECHAT_APP_ID);
        api.registerApp(DataUtils.WECHAT_APP_ID);
        SendAuth.Req req = new SendAuth.Req();
        req.scope = "snsapi_userinfo";
        req.state = "wx_login";
        api.sendReq(req);
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent intent) {
        super.onActivityResult(requestCode, resultCode, intent);
        if(resultCode==SearchAddressByMapPoiActivity.resultCode){
            if(intent==null||callbackContext==null){
                return;
            }
            String message=intent.getStringExtra(IntentParams.KEY_ADDRESS_INFO);
            if(TextUtils.isEmpty(message)){
                return;
            }
            if(isAddressUseForHomePage){
                SharedPreferencesUtils.getInstance().saveData(CommonKey.KEY_SELECT_LOCATION_INFO,message);
            }
            callbackContext.success(message);
        }
    }

    public void tokePhotoByCamera(CallbackContext callbackContext, int type){
        this.callbackContext=callbackContext;
        if(type==1){//摄像头拍照
            mode=false;
            isShow=true;
            isCircle=true;
            chooseMode= PictureMimeType.ofImage();
            selectMode= PictureConfig.SINGLE;
            takePhotoCamera();
        }else if(type==2){//相册选择
            isShow=false;
            isCircle=true;
            chooseMode= PictureMimeType.ofImage();
            selectMode= PictureConfig.SINGLE;
            takePhotoPicker();
        }
    }


    //上传头像
    protected void uploadUserPhoto(String path) {
        String userInfoStr= (String) SharedPreferencesUtils.getInstance().getData(CommonKey.KEY_LOGIN_USER_INFO,"");
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
        showProgressDialog("正在上传,请稍后...");
        ApiService service = RetrofitClient.getInstance(AppApplication.getInstance()).create(ApiService.class);
        HashMap<String, RequestBody> map = new HashMap<>();
        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        RequestBody userIdBody = RequestBody.create(
                MediaType.parse("multipart/form-data"),userId);
        map.put("user_id",userIdBody);

        //视频判断
        /*if(videoAdapter.getDataList().size()>0){
            File file = new File(videoAdapter.getDataList().get(0).getPath());//filePath 图片地址
            RequestBody imageBody = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            Log.i("hhh","videoSize:"+videoAdapter.getDataList().size());
            UploadFileRequestBody uploadFileRequestBody=new UploadFileRequestBody(imageBody,new UploadFileRequestBody.ProgressRequestListener() {
                @Override
                public void onRequestProgress(long hasWrittenLen, long totalLen, boolean hasFinish) {
                    double r = (double) hasWrittenLen / (double) totalLen;
                    videoAdapter.getDataList().get(0).setHasFinish(hasFinish);
                    videoAdapter.getDataList().get(0).setUploadProgress((int)(r*100)+"%");
                    videoAdapter.notifyItemChanged(0);
                }
            });
            //map.put("pic[]", imageBody);//requestBodyMap.put("file\"; filename=\"" + file.getName(), fileRequestBody);
            map.put("video\"; filename=\"" + file.getName(), uploadFileRequestBody);
        }*/
        /*if(adapter.getDataList().size()>0) {
            for (int i = 0; i < adapter.getDataList().size(); i++) {
                File file = new File(adapter.getDataList().get(i).getCutPath());//filePath 图片地址
                RequestBody imageBody = RequestBody.create(MediaType.parse("multipart/form-data"), file);
                final int finalI = i;
                UploadFileRequestBody uploadFileRequestBody = new UploadFileRequestBody(imageBody, new UploadFileRequestBody.ProgressRequestListener() {
                    @Override
                    public void onRequestProgress(long hasWrittenLen, long totalLen, boolean hasFinish) {
                        double r = (double) hasWrittenLen / (double) totalLen;
                        adapter.getDataList().get(finalI).setHasFinish(hasFinish);
                        adapter.getDataList().get(finalI).setUploadProgress((int)(r*100)+"%");
                        adapter.notifyItemChanged(finalI+1);
                    }
                });
                //map.put("pic[]", imageBody);//requestBodyMap.put("file\"; filename=\"" + file.getName(), fileRequestBody);
                map.put("images[]\"; filename=\"" + file.getName(), uploadFileRequestBody);
            *//*下面这里没有为什么，在不带进度的上传接口（使用@Multipart）调试成功后，用fiddler抓包获取request的正确格式 Content-Disposition: form-data; name="file"; filename="avatar1.jpg" *//*
                //fileKey += "\"; filename=\"" + mUploadedFile.getName();
            }
        }*/
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
        Call<BaseResponse> resultCall = service.uploadFiles( "多个文件上传", map);

        resultCall.enqueue(new Callback<BaseResponse>() {
            @Override
            public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {
                BaseResponse baseResponse=response.body();
                Log.i("bbb","code="+response.code()+"isSuccessful="+response.isSuccessful()+"原因"+baseResponse.getCode()+baseResponse.getMsg());
                // Response Success or Fail
                Log.i("bbbbb",""+baseResponse.getData()+"");
                dismissProgressDialog();
                if (baseResponse.getCode()==200) {
                    String path= (String) baseResponse.getData();
                    callbackContext.success(path);
                    Toast.makeText(getActivity(),baseResponse.getMsg(),Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(getActivity(),"上传失败",Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<BaseResponse> call, Throwable t) {
                //Log.i("bbb===",t.getMessage()+ "   =====   "+t.toString());
                dismissProgressDialog();
                if (t instanceof java.net.SocketTimeoutException) {
                    Toast.makeText(getActivity(),"连接超时",Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(getActivity(),"上传失败",Toast.LENGTH_SHORT).show();
                }

            }
        });
    }

    //系统相册选择 http://www.jianshu.com/p/eaf122537740
    /*private void tokePhotoFromSystem(){
        Intent intent = new Intent(Intent.ACTION_PICK, null);
        intent.setDataAndType(MediaStore.Images.Media.EXTERNAL_CONTENT_URI, "image*//*");
        startActivityForResult(intent, IntentParam.GET_IMAGE_LOCAL);
    }*/
    /*
    * protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        //super.onActivityResult(requestCode, resultCode, data);
        switch (requestCode) {
            case IntentParam.GET_IMAGE_LOCAL:
                if (data == null) {
                    return;
                }
                startPhotoZoom(data.getData());
    *
    * */
    protected void takePhotoCamera(){
        selectMedia.clear();
        PictureSelector.create(getActivity())
                .openCamera(chooseMode)// 全部.PictureMimeType.ofAll()、图片.ofImage()、视频.ofVideo()、音频.ofAudio()
                .theme(R.style.picture_default_style)// 主题样式设置 具体参考 values/styles   用法：R.style.picture.white.style
                .maxSelectNum(maxSelectNum)// 最大图片选择数量
                .minSelectNum(1)// 最小选择数量
                .imageSpanCount(4)// 每行显示个数
                .selectionMode(selectMode)// 多选 or 单选
                .previewImage(true)// 是否可预览图片
                .previewVideo(false)// 是否可预览视频
                .enablePreviewAudio(false) // 是否可播放音频
                .compressGrade(Luban.THIRD_GEAR)// luban压缩档次，默认3档 Luban.FIRST_GEAR、Luban.CUSTOM_GEAR
                .isCamera(isShow)// 是否显示拍照按钮
                .isZoomAnim(true)// 图片列表点击 缩放效果 默认true
                //.setOutputCameraPath("/CustomPath")// 自定义拍照保存路径

                .enableCrop(true)// 是否裁剪
                .compress(true)// 是否压缩
                .compressMode(PictureConfig.LUBAN_COMPRESS_MODE)//系统自带 or 鲁班压缩 PictureConfig.SYSTEM_COMPRESS_MODE or LUBAN_COMPRESS_MODE
                //.sizeMultiplier(0.5f)// glide 加载图片大小 0~1之间 如设置 .glideOverride()无效
                .glideOverride(160, 160)// glide 加载宽高，越小图片列表越流畅，但会影响列表图片浏览的清晰度
                .withAspectRatio(aspect_ratio_x, aspect_ratio_y)// 裁剪比例 如16:9 3:2 3:4 1:1 可自定义
                .hideBottomControls(true)// 是否显示uCrop工具栏，默认不显示
                .isGif(false)// 是否显示gif图片
                .freeStyleCropEnabled(false)// 裁剪框是否可拖拽
                .circleDimmedLayer(isCircle)// 是否圆形裁剪
                .showCropFrame(false)// 是否显示裁剪矩形边框 圆形裁剪时建议设为false
                .showCropGrid(false)// 是否显示裁剪矩形网格 圆形裁剪时建议设为false
                .openClickSound(false)// 是否开启点击声音
                .selectionMedia(selectMedia)// 是否传入已选图片
                //.previewEggs(false)// 预览图片时 是否增强左右滑动图片体验(图片滑动一半即可看到上一张是否选中)
                //.cropCompressQuality(90)// 裁剪压缩质量 默认100
                //.compressMaxKB()//压缩最大值kb compressGrade()为Luban.CUSTOM_GEAR有效
                //.compressWH() // 压缩宽高比 compressGrade()为Luban.CUSTOM_GEAR有效
                //.cropWH()// 裁剪宽高比，设置如果大于图片本身宽高则无效
                //.rotateEnabled() // 裁剪是否可旋转图片
                //.scaleEnabled()// 裁剪是否可放大缩小图片
                //.videoQuality()// 视频录制质量 0 or 1
                //.videoSecond()//显示多少秒以内的视频or音频也可适用
                //.recordVideoSecond()//录制视频秒数 默认60s
                .forResult(PictureConfig.CHOOSE_REQUEST);//结果回调onActivityResult code
    }

    protected void takePhotoPicker(){
        selectMedia.clear();
        PictureSelector.create(getActivity())
                .openGallery(chooseMode)// 全部.PictureMimeType.ofAll()、图片.ofImage()、视频.ofVideo()、音频.ofAudio()
                .theme(R.style.picture_default_style)// 主题样式设置 具体参考 values/styles   用法：R.style.picture.white.style
                .maxSelectNum(maxSelectNum)// 最大图片选择数量
                .minSelectNum(1)// 最小选择数量
                .imageSpanCount(4)// 每行显示个数
                .selectionMode(selectMode)// 多选 or 单选
                .previewImage(true)// 是否可预览图片
                .previewVideo(false)// 是否可预览视频
                .enablePreviewAudio(false) // 是否可播放音频
                .compressGrade(Luban.THIRD_GEAR)// luban压缩档次，默认3档 Luban.FIRST_GEAR、Luban.CUSTOM_GEAR
                .isCamera(isShow)// 是否显示拍照按钮
                .isZoomAnim(true)// 图片列表点击 缩放效果 默认true
                //.setOutputCameraPath("/CustomPath")// 自定义拍照保存路径
                .enableCrop(true)// 是否裁剪
                .compress(true)// 是否压缩
                .compressMode(PictureConfig.LUBAN_COMPRESS_MODE)//系统自带 or 鲁班压缩 PictureConfig.SYSTEM_COMPRESS_MODE or LUBAN_COMPRESS_MODE
                //.sizeMultiplier(0.5f)// glide 加载图片大小 0~1之间 如设置 .glideOverride()无效
                .glideOverride(160, 160)// glide 加载宽高，越小图片列表越流畅，但会影响列表图片浏览的清晰度
                .withAspectRatio(aspect_ratio_x, aspect_ratio_y)// 裁剪比例 如16:9 3:2 3:4 1:1 可自定义
                .hideBottomControls(true)// 是否显示uCrop工具栏，默认不显示
                .isGif(false)// 是否显示gif图片
                .freeStyleCropEnabled(false)// 裁剪框是否可拖拽
                .circleDimmedLayer(isCircle)// 是否圆形裁剪
                .showCropFrame(false)// 是否显示裁剪矩形边框 圆形裁剪时建议设为false
                .showCropGrid(false)// 是否显示裁剪矩形网格 圆形裁剪时建议设为false
                .openClickSound(false)// 是否开启点击声音
                .selectionMedia(selectMedia)// 是否传入已选图片
                //.previewEggs(false)// 预览图片时 是否增强左右滑动图片体验(图片滑动一半即可看到上一张是否选中)
                //.cropCompressQuality(90)// 裁剪压缩质量 默认100
                //.compressMaxKB()//压缩最大值kb compressGrade()为Luban.CUSTOM_GEAR有效
                //.compressWH() // 压缩宽高比 compressGrade()为Luban.CUSTOM_GEAR有效
                //.cropWH()// 裁剪宽高比，设置如果大于图片本身宽高则无效
                //.rotateEnabled() // 裁剪是否可旋转图片
                //.scaleEnabled()// 裁剪是否可放大缩小图片
                //.videoQuality()// 视频录制质量 0 or 1
                //.videoSecond()//显示多少秒以内的视频or音频也可适用
                //.recordVideoSecond()//录制视频秒数 默认60s
                .forResult(PictureConfig.CHOOSE_REQUEST);//结果回调onActivityResult code
    }


}
