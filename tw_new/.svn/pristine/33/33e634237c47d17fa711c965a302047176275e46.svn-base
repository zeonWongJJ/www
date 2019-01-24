package app.vdao.qidu.mvp.presenter;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Environment;
import android.support.v4.content.FileProvider;
import android.text.TextUtils;
import android.util.Log;
import android.widget.Toast;

import com.app.base.bean.AppInfo;
import com.app.base.bean.Store;
import com.app.base.utils.CommonKey;
import com.app.base.utils.DataUtils;
import com.app.base.utils.IntentParams;
import com.app.base.utils.PhotoUtils;
import com.common.lib.base.BaseApplication;
import com.common.lib.fileutils.FileUtils;
import com.common.lib.utils.SharedPreferencesUtils;
import com.mvp.lib.presenter.BasePresenter;
import com.net.rx_retrofit_network.location.model.BaseResponse;
import com.tencent.mm.opensdk.modelmsg.SendAuth;
import com.tencent.mm.opensdk.openapi.IWXAPI;
import com.tencent.mm.opensdk.openapi.WXAPIFactory;
import com.view.jameson.library.ScreenUtil;

import org.apache.cordova.api.CallbackContext;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

import app.vdao.qidu.activity.CredentialsUploadActivity;
import app.vdao.qidu.activity.SearchAddressByMapPoiActivity;
import app.vdao.qidu.mvp.contract.HomeContract;
import app.vdao.qidu.mvp.model.DownLoadModelImpl;
import app.vdao.qidu.mvp.model.HomeModeImpl;
import app.vdao.qidu.utils.VersionUpdateManager;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * 包含cordovaview页面的presenter
 */

public class HomePresenterImpl extends BasePresenter<HomeContract.View> implements HomeContract.Presenter{
    public CallbackContext callbackContext;

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

    private HomeModeImpl homeModeImpl;
    public DownLoadModelImpl downLoadModelImpl;
    @Override
    public void onCreate() {
        homeModeImpl=new HomeModeImpl();
        downLoadModelImpl=new DownLoadModelImpl();
        IntentFilter intentFilter = new IntentFilter();
        intentFilter.addAction(IntentParams.ACTION_GET_USER_INFO_BY_WX_LOGIN);
        mView.getActivity().registerReceiver(broadcastReceiver, intentFilter);



    }

    @Override
    public void loadData() {

    }

    @Override
    public void checkAppVersion(boolean isHomePage) {
        Disposable disposable =homeModeImpl.checkAppVersion().subscribeWith(new DisposableObserver<AppInfo>() {
            @Override
            public void onNext(@NonNull AppInfo appInfo) {
                //Log.i("aaaaaaaa","response"+stores.size()+stores.get(0).getStore_name());
                VersionUpdateManager versionUpdateManager=new VersionUpdateManager(mView.getActivity(),isHomePage);
                versionUpdateManager.updateVersion(appInfo);
            }

            @Override
            public void onError(@NonNull Throwable e) {
                //Log.i("aaaaaaaa","onError"+e.getMessage());
            }
            @Override
            public void onComplete() {

            }
        });
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void startLocationCurrentPosition(CallbackContext callbackContext) {
        homeModeImpl.startLocationCurrentPosition(callbackContext);
    }




    private static final int  CODE_GALLERY_REQUEST = 0xa0;
    private static final int  CODE_CAMERA_REQUEST  = 0xa1;
    private static final int  CODE_RESULT_REQUEST  = 0xa2;
    private File fileUri = new File(Environment.getExternalStorageDirectory().getPath() + "/photo.jpg");
    private File fileCropUri;
    private Uri imageUri;
    private Uri cropImageUri;
    public void tokePhotoByCamera(CallbackContext callbackContext, int type){
        this.callbackContext=callbackContext;
        if(!FileUtils.checkSDCard()){
            Toast.makeText(mView.getActivity(),"设备没有SD卡！",Toast.LENGTH_SHORT).show();
            return;
        }
        if(type==1){//摄像头拍照
            imageUri = Uri.fromFile(fileUri);
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
                //通过FileProvider创建一个content类型的Uri
                //imageUri = FileProvider.getUriForFile(mView.getActivity(), mView.getActivity().getPackageName(), fileUri);
                String authority = mView.getActivity().getPackageName() + ".provider";
                imageUri = FileProvider.getUriForFile(mView.getActivity(),authority, fileUri);
            }
            PhotoUtils.takePicture(mView.getActivity(), imageUri, CODE_CAMERA_REQUEST);
        }else if(type==2){//相册选择
            PhotoUtils.openPic(mView.getActivity(),CODE_GALLERY_REQUEST);
        }
    }
    /*private File createImageFile() throws IOException {
        @SuppressLint("SimpleDateFormat") String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "img_"+timeStamp+"_";
        return new File(FileUtils.getDiskCacheDir(mView.getActivity()).getPath()+"/"+ imageFileName+".jpg");
    }*/
    //private int output_X = 480, output_Y = 480;
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
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
                SharedPreferencesUtils.getInstance(BaseApplication.getInstance()).saveData(CommonKey.KEY_SELECT_LOCATION_INFO,message);
            }
            callbackContext.success(message);
        }else if(requestCode==CODE_CAMERA_REQUEST&& resultCode==Activity.RESULT_OK){//拍照完成回调
            try {
                fileCropUri = FileUtils.createImageFile(mView.getActivity());

                cropImageUri = Uri.fromFile(fileCropUri);
                /*int output_X = ScreenUtil.dip2px(mView.getActivity(),45);
                int output_Y = ScreenUtil.dip2px(mView.getActivity(),45);*/
                PhotoUtils.cropImageUri(mView.getActivity(), imageUri, cropImageUri, CODE_RESULT_REQUEST);

            } catch (IOException e) {
                e.printStackTrace();
            }

        }else if(requestCode==CODE_GALLERY_REQUEST&& resultCode==Activity.RESULT_OK){////访问相册完成回调
            if(intent==null){
                return;
            }
            if(intent.getData()==null){
                return;
            }
            try {
                fileCropUri = FileUtils.createImageFile(mView.getActivity());
                cropImageUri = Uri.fromFile(fileCropUri);
                //storage/emulated/0/DCIM/Camera/IMG_20180101_223938.jpg
                //Log.i("aaaa",cropImageUri.getPath());
                Uri newUri = Uri.parse(PhotoUtils.getPath(mView.getActivity(), intent.getData()));
                String authority = mView.getActivity().getPackageName() + ".provider";
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N)
                    newUri = FileProvider.getUriForFile(mView.getActivity(),authority, new File(newUri.getPath()));
                /*int output_X = ScreenUtil.dip2px(mView.getActivity(),45);
                int output_Y = ScreenUtil.dip2px(mView.getActivity(),45);*/
                PhotoUtils.cropImageUri(mView.getActivity(), newUri, cropImageUri, CODE_RESULT_REQUEST);

            } catch (IOException e) {
                e.printStackTrace();
            }

        }else if(requestCode==CODE_RESULT_REQUEST&& resultCode==Activity.RESULT_OK){//裁剪完成
            //Toast.makeText(mView.getActivity(),"裁剪之后",Toast.LENGTH_SHORT).show();
            //Log.i("vvvvvv",cropImageUri+"========="+fileCropUri);
            /*if(cropImageUri==null||fileCropUri==null){
                return;
            }*/
            //防止取消裁剪的时候闪退
            if(intent==null){
                return;
            }
            /*if(intent.getData()==null){
                return;
            }*/
            /*Bitmap bitmap = PhotoUtils.getBitmapFromUri(cropImageUri, this);
                    if (bitmap != null) {
                        showImages(bitmap);
                    }*/
            String path=fileCropUri.getPath();
            Bitmap bitmap=PhotoUtils.getLocalThumbImg(path,path,200);
            if(bitmap==null){
                return;
            }
            PhotoUtils.saveBitmapFile(bitmap,fileCropUri);
            String lastPath=fileCropUri.getPath();
            //String path=PhotoUtils.getPath(mView.getActivity(),cropImageUri);
            //photoSelectResult(path);
            mView.showLoadingDialog("正在上传...");
            homeModeImpl.uploadUserPhoto(lastPath,new Callback<BaseResponse>() {
                @Override
                public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {
                    BaseResponse baseResponse=response.body();
                    Log.i("bbb","code="+response.code()+"isSuccessful="+response.isSuccessful()+"原因"+baseResponse.getCode()+baseResponse.getMsg());

                    //dismissProgressDialog();
                    if (baseResponse.getCode()==200) {
                        String path= (String) baseResponse.getData();
                        callbackContext.success(path);
                        //Toast.makeText(getActivity(),baseResponse.getMsg(),Toast.LENGTH_SHORT).show();
                        mView.showToast(baseResponse.getMsg());
                    }else {
                        mView.showToast("上传失败");
                    }
                    mView.dismissLoadingDialog();
                }

                @Override
                public void onFailure(Call<BaseResponse> call, Throwable t) {
                    mView.showToast("上传失败");
                    mView.dismissLoadingDialog();
                }
            });
        }else if(requestCode==CredentialsUploadActivity.CREDENTIALS_REQUEST_CODE&&resultCode==CredentialsUploadActivity.CREDENTIALS_RESULT_CODE){
            if(intent==null){
                return;
            }
            String result=intent.getStringExtra(IntentParams.KEY_CREDENTIALS_URL);
            if(callbackContext!=null){
                callbackContext.success(result);
            }
        }
    }



    //二维码条形码扫描
    /*public void qrCodeScan(CallbackContext callbackContext,int qrCodeType){
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
    }*/

    //证件上传
    public void credentialsUpload(CallbackContext callbackContext,int type,String business_license_url,String identity_positive_url,String identity_native_url){
        this.callbackContext=callbackContext;
        Intent intent=new Intent(mView.getActivity(),CredentialsUploadActivity.class);
        intent.putExtra(IntentParams.KEY_CREDENTIALS_TYPE,type);
        intent.putExtra(IntentParams.KEY_BUSINESS_LICENSE_URL,business_license_url);
        intent.putExtra(IntentParams.KEY_IDENTITY_POSITIVE_URL,identity_positive_url);
        intent.putExtra(IntentParams.KEY_IDENTITY_NATIVE_URL,identity_native_url);
        mView.getActivity().startActivityForResult(intent,CredentialsUploadActivity.CREDENTIALS_REQUEST_CODE);
    }


    private boolean isAddressUseForHomePage;
    public void addressLocation(CallbackContext callbackContext,boolean isAddressUseForHomePage,double latitude,double longitude,String cityCode){
        this.callbackContext=callbackContext;
        this.isAddressUseForHomePage=isAddressUseForHomePage;
        Intent intent=new Intent(mView.getActivity(),SearchAddressByMapPoiActivity.class);
        intent.putExtra(IntentParams.KEY_LATITUDE,latitude);
        intent.putExtra(IntentParams.KEY_LONGITUDE,longitude);
        intent.putExtra(IntentParams.KEY_CITY_CODE,cityCode);
        mView.getActivity().startActivityForResult(intent,0x789);
    }
    /*授权登录*/
    public void WXLogin(CallbackContext callbackContext){
        this.callbackContext=callbackContext;
        IWXAPI api = WXAPIFactory.createWXAPI(mView.getActivity(), DataUtils.WECHAT_APP_ID);
        api.registerApp(DataUtils.WECHAT_APP_ID);
        SendAuth.Req req = new SendAuth.Req();
        req.scope = "snsapi_userinfo";
        req.state = "wx_login";
        api.sendReq(req);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();

        //销毁定位
        homeModeImpl.destroyLocation();
        mView.getActivity().unregisterReceiver(broadcastReceiver);
    }
}
