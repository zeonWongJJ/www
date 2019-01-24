package com.app.base.httpUtil;

import com.androidnetworking.interfaces.UploadProgressListener;
import com.app.base.utils.HttpUrl;
import com.rx2androidnetworking.Rx2AndroidNetworking;

import java.io.File;
import java.util.HashMap;

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
    public Disposable uploadFile(String path, UploadProgressListener progressListener, DisposableObserver<String> observer){
        HashMap<String,String> hashMap=new HashMap<>();
        /*if(LoginUtil.getInstance().getLoginUser()!=null){
            hashMap.put("token",LoginUtil.getInstance().getLoginUser().getToken()+"");
            hashMap.put("member_id",LoginUtil.getInstance().getLoginUser().getMember_id()+"");
        }*/
        //join_upload
        Disposable disposable= Rx2AndroidNetworking.upload(HttpUrl.api_upload_file)
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
    public Disposable uploadImg(String path, UploadProgressListener progressListener, DisposableObserver<String> observer){
        HashMap<String,String> hashMap=new HashMap<>();
        /*if(LoginUtil.getInstance().getLoginUser()!=null){
            hashMap.put("token",LoginUtil.getInstance().getLoginUser().getToken()+"");
            hashMap.put("member_id",LoginUtil.getInstance().getLoginUser().getMember_id()+"");
        }*/
        Disposable disposable= Rx2AndroidNetworking.upload(HttpUrl.api_upload_img)
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
