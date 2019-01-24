package app.vdao.qidu.activity;

import android.app.Dialog;
import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.graphics.BitmapFactory;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

import com.gzqx.common.base.AbsBaseActivity;
import com.gzqx.common.httpbase.net.BaseResponse;
import com.gzqx.common.httpbase.net.RetrofitClient;
import com.gzqx.common.httpbase.net.UploadFileRequestBody;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.compress.Luban;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.tools.ScreenUtils;

import app.vdao.qidu.AppApplication;
import app.vdao.qidu.R;
import app.vdao.qidu.util.ApiService;

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

/**
 * Created by 7du-28 on 2017/12/28.
 */

public abstract class BaseUploadPictureActivity extends AbsBaseActivity{

    protected void showTipDialog(int uploadType){
        final Dialog dialog = new Dialog(getActivity(), R.style.AlertDialogStyle);
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.layout_dialog_upload_tips,null);
        ImageView bg_simple=view.findViewById(R.id.bg_simple);
        if(uploadType==1){//营业执照
            bg_simple.setImageResource(R.drawable.business_license_sample);
        }else {
            bg_simple.setImageResource(R.drawable.bg_identity_sample);
        }
        View clickToPhone=view.findViewById(R.id.dismiss_btn);
        clickToPhone.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(dialog!=null){
                    dialog.dismiss();
                }
            }
        });
        dialog.setContentView(view);
        dialog.setCancelable(false);
        dialog.setCanceledOnTouchOutside(false);
        dialog.show();
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (resultCode == RESULT_OK) {
            switch (requestCode) {
                case PictureConfig.CHOOSE_REQUEST:
                    selectMedia = PictureSelector.obtainMultipleResult(data);
                    if(selectMedia.size()>0){
                        photoSelectResult(selectMedia.get(0));
                    }
                    break;
            }
        }
    }

    protected void photoSelectResult(LocalMedia media){
        //上传图片，然后回调给js
        String picturePath=media.getCutPath();
        if(picturePath==null){
            picturePath=media.getPath();
        }
        if(picturePath==null){
            return;
        }
        Log.i("aaaaaaaaa","path"+picturePath);
        uploadPhoto(picturePath);

    }
    //图片选择--------------------------------------------------
    private int maxSelectNum = 9;// 图片最大可选数量
    private int chooseMode = PictureMimeType.ofImage();
    protected List<LocalMedia> selectMedia = new ArrayList<>();
    private int selectMode = PictureConfig.SINGLE;
    protected boolean isShow = true;
    protected boolean isCircle=false;
    protected int aspect_ratio_x=16,aspect_ratio_y=9;
    private int with=320,height=180;
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
                .compressGrade(Luban.CUSTOM_GEAR)// luban压缩档次，默认3档 Luban.FIRST_GEAR、Luban.CUSTOM_GEAR
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
                .cropCompressQuality(80)// 裁剪压缩质量 默认100
                .compressMaxKB(1024*2)//压缩最大值kb compressGrade()为Luban.CUSTOM_GEAR有效
                .compressWH(ScreenUtils.dip2px(getActivity(),with), ScreenUtils.dip2px(getActivity(),height)) // 压缩宽高比 compressGrade()为Luban.CUSTOM_GEAR有效
                .cropWH(ScreenUtils.dip2px(getActivity(),with), ScreenUtils.dip2px(getActivity(),height))// 裁剪宽高比，设置如果大于图片本身宽高则无效
                //.rotateEnabled() // 裁剪是否可旋转图片
                //.scaleEnabled()// 裁剪是否可放大缩小图片
                //.videoQuality()// 视频录制质量 0 or 1
                //.videoSecond()//显示多少秒以内的视频or音频也可适用
                //.recordVideoSecond()//录制视频秒数 默认60s`
                .forResult(PictureConfig.CHOOSE_REQUEST);//结果回调onActivityResult code
    }
    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(new ContextWrapper(newBase) {
            @Override
            public Object getSystemService(String name) {
                if (Context.AUDIO_SERVICE.equals(name))
                    return getApplicationContext().getSystemService(name);
                return super.getSystemService(name);
            }
        });
    }


    protected void uploadPhoto(final String path) {

        showProgressDialog("正在上传,请稍后...");
        ApiService service = RetrofitClient.getInstance(AppApplication.getInstance()).create(ApiService.class);
        HashMap<String, RequestBody> map = new HashMap<>();
        RequestBody tokenBody = RequestBody.create(
                MediaType.parse("multipart/form-data"), "token");
        /*RequestBody userIdBody = RequestBody.create(
                MediaType.parse("multipart/form-data"),userId);*/
        //map.put("user_id",userIdBody);

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
        map.put("file\"; filename=\"" + file.getName(), uploadFileRequestBody);
        Map<String, String> headers=new HashMap<>();
        Call<BaseResponse> resultCall = service.uploadCredentialsPic( "上传证件", map);

        resultCall.enqueue(new Callback<BaseResponse>() {
            @Override
            public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {
                BaseResponse baseResponse=response.body();
                Log.i("bbb","code="+response.code()+"isSuccessful="+response.isSuccessful()+"原因"+baseResponse.getCode()+baseResponse.getMsg());
                // Response Success or Fail
                Log.i("bbbbb",""+baseResponse.getData()+"");
                dismissProgressDialog();
                if (baseResponse.getCode()==200) {
                    String url= (String) baseResponse.getData();
                    Toast.makeText(getActivity(),baseResponse.getMsg(),Toast.LENGTH_SHORT).show();
                    uploadSuccess(path,url);
                }else {
                    Toast.makeText(getActivity(),"上传失败",Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<BaseResponse> call, Throwable t) {
                Log.i("bbb===",t.getMessage()+ "   =====   "+t.toString());
                dismissProgressDialog();
                if (t instanceof java.net.SocketTimeoutException) {
                    Toast.makeText(getActivity(),"连接超时",Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(getActivity(),"上传失败",Toast.LENGTH_SHORT).show();
                }

            }
        });
    }

    protected abstract void uploadSuccess(String path,String url);
}
