package com.app.base.netUtil;

import android.util.Log;

import com.androidnetworking.interfaces.UploadProgressListener;
import com.app.base.utils.HttpUrl;
import com.app.base.utils.LoginUtil;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import org.json.JSONObject;

import java.io.File;
import java.util.HashMap;

import io.reactivex.Observer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * 上传
 */

public class UploadUtil {
    private static UploadUtil uploadUtil;
    public static UploadUtil getInstance(){
        if(uploadUtil==null){
            uploadUtil=new UploadUtil();
        }
        return uploadUtil;
    }
    //上传单个文件  多个传Map<String, File>
    public Disposable uploadFile(String path,UploadProgressListener progressListener,DisposableObserver<String> observer){
        HashMap<String,String> hashMap=new HashMap<>();
        String token="";
        if(LoginUtil.getInstance().getLoginUser()!=null){
            Log.i("token---",LoginUtil.getInstance().getLoginUser().getToken()+"");
            token=LoginUtil.getInstance().getLoginUser().getToken();
            //"d324c1f2c4714f907fadc45225d4c25a"
            hashMap.put("token",token);
            //map.put("token","8545e0952110fbb24632248864db09bd");
        }
        Disposable disposable=Rx2AndroidNetworking.upload(HttpUrl.api_upload_file)
                .addHeaders("x-token",token)
                .addMultipartFile("file", new File(path))
                .addMultipartParameter(hashMap)
                .setTag(path)
                .build()
                .setUploadProgressListener(progressListener)
                .getStringObservable()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
        return disposable;
    }

    //上传单个文件  多个传Map<String, File>
    public Disposable uploadImg(String path,UploadProgressListener progressListener,DisposableObserver<String> observer){
        HashMap<String,String> hashMap=new HashMap<>();
        String token="";
        if(LoginUtil.getInstance().getLoginUser()!=null){
            Log.i("token---",LoginUtil.getInstance().getLoginUser().getToken()+"");
            token=LoginUtil.getInstance().getLoginUser().getToken();
            //"d324c1f2c4714f907fadc45225d4c25a"
            hashMap.put("token",token);
            //map.put("token","8545e0952110fbb24632248864db09bd");
        }
        Disposable disposable=Rx2AndroidNetworking.upload(HttpUrl.api_upload_img)
                .addHeaders("x-token",token)
                .addMultipartFile("image", new File(path))
                .addMultipartParameter(hashMap)
                .setTag(path)
                .build()
                .setUploadProgressListener(progressListener)
                .getStringObservable()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeWith(observer);
        return disposable;
    }

}
