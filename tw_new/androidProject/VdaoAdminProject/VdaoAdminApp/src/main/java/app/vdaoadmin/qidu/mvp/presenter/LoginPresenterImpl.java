package app.vdaoadmin.qidu.mvp.presenter;


import android.graphics.BitmapFactory;
import android.util.Log;

import app.vdaoadmin.qidu.mvp.contract.LoginContract;
import app.vdaoadmin.qidu.mvp.model.LoginModelImpl;
import app.vdaoadmin.qidu.mvp.apiservice.ApiServcieImpl;

import com.app.base.bean.Admin;
import com.app.base.bean.AdminBean;
import com.net.rx_retrofit_network.location.requestbody.UploadFileRequestBody;
import com.net.rx_retrofit_network.location.rxandroid.ModelFilterFactory;
import com.mvp.lib.presenter.BasePresenter;

import java.io.File;
import java.util.HashMap;
import java.util.List;

import io.reactivex.Observable;
import io.reactivex.annotations.NonNull;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import okhttp3.MediaType;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;


public class LoginPresenterImpl extends BasePresenter<LoginContract.View> implements LoginContract.Presenter{

    private LoginModelImpl loginModelImpl;
    @Override
    public void onCreate(){
        loginModelImpl = new LoginModelImpl();//创建modle实例
    }

    @Override
    public void loadData() {

        //普通post请求
        /*HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("ip", "21.22.11.33");
        Observable<ResponseBody> observable= ModelFilterFactory.composeResponseBody(ApiServcieImpl.getInstance().executePost("http://ip.taobao.com/service/getIpInfo.php",hasMap));
        Disposable disposable =observable.subscribeWith(new DisposableObserver<ResponseBody>(){
            @Override
            public void onNext(@NonNull ResponseBody responseBody) {
                Log.e("aaaaa", "post--->"+responseBody.toString());
            }

            @Override
            public void onError(@NonNull Throwable e) {
                Log.e("aaaaa", "post onError--->"+e.getMessage());
            }

            @Override
            public void onComplete() {
                Log.e("aaaaa", "onComplete--->");
            }
        });
        mCompositeSubscription.add(disposable);*/
    }

    @Override
    public void login(String admin_name,String admin_password){
        //通过modle请求接口
        HashMap<String,String> hasMap=new HashMap<String, String>();
        hasMap.put("admin_name",admin_name);
        hasMap.put("admin_password",admin_password);
        Disposable disposable =loginModelImpl.login(hasMap)
                .subscribeWith(new DisposableObserver<Admin>() {
                    @Override
                    public void onNext(@NonNull Admin admin) {
                        AdminBean.deleteAdminBean();
                        AdminBean adminBean=new AdminBean();
                        if(admin!=null){
                            adminBean.setAdmin_email(admin.getAdmin_email());
                            adminBean.setAdmin_id(admin.getAdmin_id());
                            adminBean.setAdmin_name(admin.getAdmin_name());
                            adminBean.setAdmin_phone(admin.getAdmin_phone());
                            adminBean.setAdmin_realname(admin.getAdmin_realname());
                            adminBean.setAdmin_sex(admin.getAdmin_sex());
                            adminBean.setRole_id(admin.getRole_id());
                            adminBean.setAdmin_state(admin.getAdmin_state());
                            adminBean.setToken(admin.getToken());
                            adminBean.save();
                        }
                        mView.loginSuccess(admin);
                    }

                    @Override
                    public void onError(@NonNull Throwable e) {
                        mView.loginFailure(e);
                    }
                    @Override
                    public void onComplete() {

                    }
                });
        mCompositeSubscription.add(disposable);//添加订阅
    }



    public void uploadFileTest(String path) {

        //普通post请求
        HashMap<String, RequestBody> hasMap=new HashMap<>();
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
        hasMap.put("user_pic\"; filename=\"" + file.getName(), uploadFileRequestBody);

        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        RequestBody userIdBody = RequestBody.create(
                MediaType.parse("multipart/form-data"),"userId");
        hasMap.put("user_id",userIdBody);
        Observable<ResponseBody> observable= ModelFilterFactory.composeResponseBody(ApiServcieImpl.getInstance().uploadFiles("http://ip.taobao.com/service/getIpInfo.php",hasMap));
        Disposable disposable =observable.subscribeWith(new DisposableObserver<ResponseBody>(){
            @Override
            public void onNext(@NonNull ResponseBody responseBody) {
                Log.e("aaaaa", "post--->"+responseBody.toString());
            }

            @Override
            public void onError(@NonNull Throwable e) {
                Log.e("aaaaa", "post onError--->"+e.getMessage());
            }

            @Override
            public void onComplete() {
                Log.e("aaaaa", "onComplete--->");
            }
        });
        mCompositeSubscription.add(disposable);
    }
}