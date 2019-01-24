package app.vdao.qidu.activity;

import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.os.Vibrator;
import android.view.SurfaceView;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.zxing.Result;
import com.gzqx.common.base.AbsBaseActivity;
import com.gzqx.common.utils.IntentParams;
import com.liang.scancode.utils.Constant;
import com.liang.scancode.zxing.ScanListener;
import com.liang.scancode.zxing.ScanManager;
import com.liang.scancode.zxing.decode.DecodeThread;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.compress.Luban;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;

import app.vdao.qidu.R;

import java.util.ArrayList;
import java.util.List;



/**
 * Created by 7du-28 on 2017/12/27.
 */

public class QRCodeScanActivity extends AbsBaseActivity implements ScanListener,View.OnClickListener{

    public static int QR_REQUEST_CODE=0x666;
    public static int QR_RESULT_CODE=0x888;
    SurfaceView scanPreview = null;
    View scanContainer;
    View scanCropView;
    ImageView scanLine;
    ScanManager scanManager;
    TextView iv_light;
    TextView qrcode_g_gallery;
    TextView qrcode_ic_back;
    private Handler handler=new Handler();


    Button rescan;
    ImageView scan_image;

    ImageView authorize_return;
    private int scanMode;//扫描模型（条形，二维码，全部）

    TextView title;
    TextView scan_hint;
    TextView tv_scan_result;



    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        scanMode=getIntent().getIntExtra(Constant.REQUEST_SCAN_MODE,Constant.REQUEST_SCAN_MODE_ALL_MODE);
        /*if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            RelativeLayout titleLayout=findViewById(R.id.top_mask);
            RelativeLayout.LayoutParams params= (RelativeLayout.LayoutParams) titleLayout.getLayoutParams();
            params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            titleLayout.setLayoutParams(params);
        }*/
        initView();
    }


    private void initView() {

        rescan=findViewById(R.id.service_register_rescan);
        scan_image=findViewById(R.id.scan_image);
        authorize_return=findViewById(R.id.authorize_return);
        title=findViewById(R.id.common_title_TV_center);
        scan_hint=findViewById(R.id.scan_hint);
        tv_scan_result=findViewById(R.id.tv_scan_result);

        scanPreview = (SurfaceView) findViewById(R.id.capture_preview);
        scanContainer = findViewById(R.id.capture_container);
        scanCropView = findViewById(R.id.capture_crop_view);
        scanLine = (ImageView) findViewById(R.id.capture_scan_line);
        qrcode_g_gallery = (TextView) findViewById(R.id.qrcode_g_gallery);
        qrcode_g_gallery.setOnClickListener(this);
        qrcode_ic_back = (TextView) findViewById(R.id.qrcode_ic_back);
        qrcode_ic_back.setOnClickListener(this);
        iv_light = (TextView) findViewById(R.id.iv_light);
        iv_light.setOnClickListener(this);
        rescan.setOnClickListener(this);
        authorize_return.setOnClickListener(this);
        //构造出扫描管理器
        scanManager = new ScanManager(this, scanPreview, scanContainer, scanCropView, scanLine, scanMode,this);

        switch (scanMode){
            case DecodeThread.BARCODE_MODE:
                title.setText(getResources().getString(R.string.scan_barcode_title));
                scan_hint.setText(getResources().getString(R.string.scan_barcode_hint));
                break;
            case DecodeThread.QRCODE_MODE:
                title.setText(getResources().getString(R.string.scan_qrcode_title));
                scan_hint.setText(getResources().getString(R.string.scan_qrcode_hint));
                break;
            case DecodeThread.ALL_MODE:
                title.setText(getResources().getString(R.string.scan_allcode_title));
                scan_hint.setText(getResources().getString(R.string.scan_allcode_hint));
                break;
        }
    }

    @Override
    public void onClick(View view) {
        int id=view.getId();
        if (id == R.id.qrcode_g_gallery) {
            scan_image.setImageBitmap(null);
            chooseMode= PictureMimeType.ofImage();
            selectMode= PictureConfig.SINGLE;
            takePhotoPicker();
        } else if (id == R.id.iv_light) {
            scanManager.switchLight();
        } else if (id == R.id.qrcode_ic_back) {
            finish();
        } else if (id == R.id.service_register_rescan) {
            startScan();
        } else if (id == R.id.authorize_return) {
            finish();
        }
    }

    @Override
    protected int getContentViewID() {
        return R.layout.activity_qr_code_scan;
    }


    @Override
    public void onResume() {
        super.onResume();
        scanManager.onResume();
        //rescan.setVisibility(View.INVISIBLE);
        //scan_image.setVisibility(View.GONE);
    }

    @Override
    public void onPause() {
        super.onPause();
        scanManager.onPause();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }



    private void vibrate() {
        Vibrator vibrator = (Vibrator) getSystemService(VIBRATOR_SERVICE);
        vibrator.vibrate(200);
    }

    /**
     *
     */
    @Override
    public void scanResult(Result rawResult, Bundle bundle) {
        //扫描成功后，扫描器不会再连续扫描，如需连续扫描，调用reScan()方法。
        //scanManager.reScan();
//		Toast.makeText(that, "result="+rawResult.getText(), Toast.LENGTH_LONG).show();
        vibrate();//震动一下
        if (!scanManager.isScanning()) { //如果当前不是在扫描状态
            //设置再次扫描按钮出现
            //rescan.setVisibility(View.VISIBLE);
            scan_image.setVisibility(View.VISIBLE);
            Bitmap barcode = null;
            byte[] compressedBitmap = bundle.getByteArray(DecodeThread.BARCODE_BITMAP);
            if (compressedBitmap != null) {
                barcode = BitmapFactory.decodeByteArray(compressedBitmap, 0, compressedBitmap.length, null);
                barcode = barcode.copy(Bitmap.Config.ARGB_8888, true);
            }
            scan_image.setImageBitmap(barcode);
        }
        //rescan.setVisibility(View.VISIBLE);
        scan_image.setVisibility(View.VISIBLE);
        tv_scan_result.setVisibility(View.VISIBLE);
        final String scanResult=rawResult.getText();
        tv_scan_result.setText("扫描结果："+scanResult);
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent intent=new Intent();
                intent.putExtra(IntentParams.KEY_QR_CODE_SCAN_RESULT_VALUE,scanResult);
                setResult(QR_RESULT_CODE,intent);
                finish();
            }
        },500);
    }

    void startScan() {
        if (rescan.getVisibility() == View.VISIBLE) {
            rescan.setVisibility(View.INVISIBLE);
            //scan_image.setVisibility(View.GONE);
            scan_image.setImageBitmap(null);
            scanManager.reScan();
        }
    }

    @Override
    public void scanError(Exception e) {
        Toast.makeText(this, e.getMessage(), Toast.LENGTH_LONG).show();
        //相机扫描出错时
        if(e.getMessage()!=null&&e.getMessage().startsWith("相机")){
            scanPreview.setVisibility(View.INVISIBLE);
        }
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
        String picturePath=media.getCompressPath();//因为设置不压缩不裁剪，所以getPath
        if(picturePath==null){
            picturePath=media.getPath();
        }
        if(picturePath==null){
            return;
        }
        scanManager.scanningImage(picturePath);
    }




    //图片选择--------------------------------------------------
    private int maxSelectNum = 9;// 图片最大可选数量
    private int chooseMode = PictureMimeType.ofAll();
    protected List<LocalMedia> selectMedia = new ArrayList<>();
    private int selectMode = PictureConfig.SINGLE;
    protected boolean isShow = false;
    protected boolean isCircle=false;
    protected int aspect_ratio_x=1,aspect_ratio_y=1;
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
                .enableCrop(false)// 是否裁剪
                .compress(true)// 是否压缩
                .compressMode(PictureConfig.LUBAN_COMPRESS_MODE)//系统自带 or 鲁班压缩 PictureConfig.SYSTEM_COMPRESS_MODE or LUBAN_COMPRESS_MODE
                //.sizeMultiplier(0.5f)// glide 加载图片大小 0~1之间 如设置 .glideOverride()无效
                .glideOverride(160, 160)// glide 加载宽高，越小图片列表越流畅，但会影响列表图片浏览的清晰度
                .withAspectRatio(aspect_ratio_x, aspect_ratio_y)// 裁剪比例 如16:9 3:2 3:4 1:1 可自定义
                .hideBottomControls(false)// 是否显示uCrop工具栏，默认不显示
                .isGif(false)// 是否显示gif图片
                .freeStyleCropEnabled(true)// 裁剪框是否可拖拽
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
}
