package com.qidu.chat.activity;

import android.media.MediaMetadataRetriever;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentActivity;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.luck.picture.lib.tools.ScreenUtils;
import com.qidu.chat.R;

import common.utils.DownloadUtil;
import io.reactivex.Observable;
import io.reactivex.ObservableEmitter;
import io.reactivex.ObservableOnSubscribe;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;
import io.reactivex.schedulers.Schedulers;

/**
 * Created by 7du-28 on 2017/10/26.
 */

public class FileDownLoadActivity extends FragmentActivity{
    TextView textView,title,textProgressPercent;
    ProgressBar progressBar;
    View back,progressContainer;
    private String link;
    private String fileKey;
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_file_down);
        textView=findViewById(R.id.download_tip);
        progressBar=findViewById(R.id.progressBar);
        back=findViewById(R.id.left_back);
        progressContainer=findViewById(R.id.progress_container);
        progressContainer.setVisibility(View.GONE);
        textProgressPercent=findViewById(R.id.text_progress_percent);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                /*if(disposable!=null){
                    disposable.dispose();
                }*/
                DownloadUtil.getInstance().cancelDown();
                finish();
            }
        });
        title=findViewById(R.id.title);
        fileKey=getIntent().getStringExtra("title");
        link=getIntent().getStringExtra("link");

        init();

    }

    //private Disposable disposable;
    private void init(){
        String path = DownloadUtil.getInstance().getFilePathByKey(DownloadUtil.downLoadFile,fileKey);
        if (path != null) {
            progressContainer.setVisibility(View.GONE);
            setData(path);
        } else {
            textView.setText("下载");
            textView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    progressContainer.setVisibility(View.VISIBLE);
                    DownloadUtil.getInstance().cancelDown();
                    DownloadUtil.getInstance().download(link, DownloadUtil.downLoadFile,fileKey, new DownloadUtil.OnDownloadListener() {
                        @Override
                        public void onDownloadSuccess() {
                            String path = DownloadUtil.getInstance().getFilePathByKey(DownloadUtil.downLoadFile, fileKey);
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    Toast.makeText(FileDownLoadActivity.this,"下载完成",Toast.LENGTH_SHORT).show();
                                    setData(path);
                                }
                            });
                        }

                        @Override
                        public void onDownloading(int progress) {
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    textProgressPercent.setText(progress+"%");
                                    progressBar.setProgress(progress);
                                }
                            });
                        }

                        @Override
                        public void onDownloadFailed() {
                            runOnUiThread(new Runnable() {
                                @Override
                                public void run() {
                                    Toast.makeText(FileDownLoadActivity.this,"下载失败",Toast.LENGTH_SHORT).show();
                                }
                            });

                        }
                    });
                }
            });
        }

        /*Observable observable = Observable.create(new ObservableOnSubscribe() {
            @Override
            public void subscribe(final ObservableEmitter e) throws Exception {

                //e.onComplete();
            }
        });
        if(disposable!=null){
            disposable.dispose();
        }
        disposable = (Disposable) observable.subscribeOn(Schedulers.io()).unsubscribeOn(Schedulers.io()).observeOn(AndroidSchedulers.mainThread()).subscribeWith(new DisposableObserver<String>() {
            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onComplete() {
            }

            @Override
            public void onNext(final String path) {

            }
        });*/
    }


    private void setData(String path){
        if(path!=null|| !TextUtils.isEmpty(path)){
            progressContainer.setVisibility(View.GONE);
            textView.setText("已经下载");
            textView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Toast.makeText(FileDownLoadActivity.this,"文件目录:"+path,Toast.LENGTH_SHORT).show();
                }
            });
        }
    }
}
