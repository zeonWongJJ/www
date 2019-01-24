package app.vdao.qidu.service;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;

import com.gzqx.common.bean.AppInfo;
import com.gzqx.common.httpbase.net.RetrofitClient;
import com.gzqx.common.sysutil.AppUtils;

import java.util.HashMap;
import java.util.Map;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/1/16.
 */

public class VersionUpdateManager {

    private Activity activity;

    private String newVerName = "";// 新版本名称
    private int newVerCode = -1;// 新版本号
    boolean isForceUpdate=false;//是否强制更新
    boolean isHomePage=true;//是否是在首页使用
    public VersionUpdateManager(Activity activity,boolean isHomePage) {
        this.activity = activity;
        this.isHomePage=isHomePage;
    }

    /**
     * 从服务器端获得版本号与版本名称
     *
     * @return
     */
    private Disposable disposable;
    public void checkAppVersion() {

            /*URL url = new URL("服务器路径/version.text");
            HttpURLConnection httpConnection = (HttpURLConnection) url
                    .openConnection();
            httpConnection.setDoInput(true);
            httpConnection.setDoOutput(true);
            httpConnection.setRequestMethod("GET");
            httpConnection.connect();
            InputStreamReader reader = new InputStreamReader(
                    httpConnection.getInputStream());
            BufferedReader bReader = new BufferedReader(reader);
            String json = bReader.readLine();
            JSONArray array = new JSONArray(json);
            JSONObject jsonObj = array.getJSONObject(0);
            newVerCode = Integer.parseInt(jsonObj.getString("verCode"));
            newVerName = jsonObj.getString("verName");*/
        Map<String, String> maps = new HashMap<String, String>();
        //maps.put("citycode", cityCode);
        if(disposable!=null){
            disposable.dispose();
        }

        disposable= RetrofitClient.getInstance(activity).createBaseApi().getAppInfo("vdaoupdate.txt", maps, new DisposableObserver<AppInfo>() {
            @Override
            public void onNext(AppInfo appInfo) {
                isForceUpdate=appInfo.isIsForceUpdate();
                newVerName=appInfo.getVersionName();
                newVerCode=appInfo.getVersionCode();
                updateVersion();
            }

            @Override
            public void onError(Throwable e) {

            }
            @Override
            public void onComplete() {

            }
        });
    }


    // 判断是否更新版本
    public void updateVersion() {
        int verCode = AppUtils.getAppVersionCode(activity);
        if(isHomePage){
            if(!isForceUpdate){
                if (newVerCode > verCode) {
                    doNewVersionUpdate();// 更新版本
                }
            }else {
                //强制更新
                if (newVerCode > verCode) {
                    Intent updateIntent =new Intent(activity, UpdateService.class);
                    updateIntent.putExtra("newVerCode",newVerCode);
                    activity.startService(updateIntent);
                }
            }
        }else {
            if (newVerCode > verCode) {
                doNewVersionUpdate();// 更新版本
            }else {
                notNewVersionUpdate();
            }
        }
    }


    /**
     * 更新版本
     */
    public void doNewVersionUpdate() {
        //int verCode =AppUtils.getAppVersionCode(activity);
        //String verName =AppUtils.getAppVersionName(activity);
        StringBuffer sb = new StringBuffer();
        /*sb.append("当前版本：");
        sb.append(verName);
        sb.append(" Code:");
        sb.append(verCode);*/
        sb.append("发现版本：");
        sb.append(newVerName);
        /*sb.append(" Code:");
        sb.append(newVerCode);*/
        //sb.append(",是否更新");
        Dialog dialog = new AlertDialog.Builder(activity)
                .setTitle("软件更新")
                .setMessage(sb.toString())
                .setPositiveButton("更新", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        Intent updateIntent =new Intent(activity, UpdateService.class);
                        activity.startService(updateIntent);
                    }
                })
                .setNegativeButton("暂不更新",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog,
                                                int which) {
                                dialog.dismiss();
                            }
                        }).create();
        // 显示更新框
        dialog.show();
    }


    /**
     * 不更新版本
     */
    public void notNewVersionUpdate() {
        //int verCode = AppUtils.getAppVersionCode(activity);
        String verName = AppUtils.getAppVersionName(activity);
        StringBuffer sb = new StringBuffer();
        sb.append("当前版本：");
        sb.append(verName);
        sb.append("\n已是最新版本，无需更新");
        Dialog dialog = new AlertDialog.Builder(activity).setTitle("软件更新")
                .setMessage(sb.toString())
                .setPositiveButton("确定", new DialogInterface.OnClickListener() {

                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                }).create();
        dialog.show();
    }
}
