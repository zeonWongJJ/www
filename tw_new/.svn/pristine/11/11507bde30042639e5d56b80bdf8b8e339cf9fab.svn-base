package app.vdao.qidu.mvp.presenter;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.Dialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Environment;
import android.support.v4.content.FileProvider;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

import com.app.base.utils.CommonKey;
import com.app.base.utils.IntentParams;
import com.app.base.utils.PhotoUtils;
import com.common.lib.base.BaseApplication;
import com.common.lib.bean.ActionItem;
import com.common.lib.fileutils.FileUtils;
import com.common.lib.utils.SharedPreferencesUtils;
import com.common.lib.widget.ActionSheetDialog;
import com.mvp.lib.presenter.BasePresenter;
import com.net.rx_retrofit_network.location.model.BaseResponse;
import com.view.jameson.library.ScreenUtil;

import org.apache.cordova.api.CallbackContext;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import app.vdao.qidu.R;
import app.vdao.qidu.mvp.contract.CredentialsUploadContract;
import app.vdao.qidu.mvp.model.CredentialsUploadModelImpl;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


/**
 * Created by 7du-28 on 2018/3/13.
 */

public class CredentialsUploadPresenterImpl extends BasePresenter<CredentialsUploadContract.View> implements CredentialsUploadContract.Presenter{
    private static final int  CODE_GALLERY_REQUEST = 0xa0;
    private static final int  CODE_CAMERA_REQUEST  = 0xa1;
    private static final int  CODE_RESULT_REQUEST  = 0xa2;
    private File fileUri = new File(Environment.getExternalStorageDirectory().getPath() + "/photo.jpg");
    private File fileCropUri;
    private Uri imageUri;
    private Uri cropImageUri;

    public void tokePhotoByCamera(int type){

        if(!FileUtils.checkSDCard()){
            Toast.makeText(mView.getActivity(),"设备没有SD卡！",Toast.LENGTH_SHORT).show();
            return;
        }
        if(type==1){//摄像头拍照
            imageUri = Uri.fromFile(fileUri);
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
                //通过FileProvider创建一个content类型的Uri
                String authority = mView.getActivity().getPackageName() + ".provider";
                imageUri = FileProvider.getUriForFile(mView.getActivity(), authority, fileUri);
            }
            PhotoUtils.takePicture(mView.getActivity(), imageUri, CODE_CAMERA_REQUEST);
        }else if(type==2){//相册选择
            PhotoUtils.openPic(mView.getActivity(),CODE_GALLERY_REQUEST);
        }
    }


    private CredentialsUploadModelImpl credentialsUploadModel;
    @Override
    public void onCreate() {
        credentialsUploadModel=new CredentialsUploadModelImpl();
    }

    @Override
    public void loadData() {

    }



    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        super.onActivityResult(requestCode, resultCode, intent);

        int output_X = ScreenUtil.dip2px(mView.getActivity(),320);
        int output_Y = ScreenUtil.dip2px(mView.getActivity(),180);
        if(requestCode==CODE_CAMERA_REQUEST&& resultCode==Activity.RESULT_OK){//拍照完成回调
            try {
                fileCropUri = FileUtils.createImageFile(mView.getActivity());
                cropImageUri = Uri.fromFile(fileCropUri);
                PhotoUtils.cropImageUri(mView.getActivity(), imageUri, cropImageUri, 16, 9, output_X, output_Y, CODE_RESULT_REQUEST);

            } catch (IOException e) {
                e.printStackTrace();
            }

        }else if(requestCode==CODE_GALLERY_REQUEST&& resultCode== Activity.RESULT_OK){////访问相册完成回调
            try {
                fileCropUri = FileUtils.createImageFile(mView.getActivity());
                cropImageUri = Uri.fromFile(fileCropUri);
                //storage/emulated/0/DCIM/Camera/IMG_20180101_223938.jpg
                //Log.i("aaaa",cropImageUri.getPath());
                Uri newUri = Uri.parse(PhotoUtils.getPath(mView.getActivity(), intent.getData()));
                String authority = mView.getActivity().getPackageName() + ".provider";
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N)
                    newUri = FileProvider.getUriForFile(mView.getActivity(),authority, new File(newUri.getPath()));
                PhotoUtils.cropImageUri(mView.getActivity(), newUri, cropImageUri, 16, 9, output_X, output_Y, CODE_RESULT_REQUEST);


            } catch (IOException e) {
                e.printStackTrace();
            }

        }else if(requestCode==CODE_RESULT_REQUEST&& resultCode==Activity.RESULT_OK){//裁剪完成
            if(intent==null){
                return;
            }
            String path=fileCropUri.getPath();
            Bitmap bitmap=PhotoUtils.getLocalThumbImg(path,path,300);
            if(bitmap==null){
                return;
            }
            PhotoUtils.saveBitmapFile(bitmap,fileCropUri);
            String lastPath=fileCropUri.getPath();
            //photoSelectResult(path);
            mView.showLoadingDialog("正在上传...");
            credentialsUploadModel.uploadCredentialsPic(lastPath,new Callback<BaseResponse>() {
                @Override
                public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {
                    BaseResponse baseResponse=response.body();
                    if (baseResponse.getCode()==200) {
                        String url= (String) baseResponse.getData();
                        mView.showToast(baseResponse.getMsg());
                        mView.uploadSuccess(path,url);
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
        }
    }

    @Override
    public void takePhotoPicker() {
        List<ActionItem> list=new ArrayList<>();
        ActionItem item=new ActionItem();
        item.setItemName("拍照");
        item.setItemType(1);
        list.add(item);
        ActionItem itemPhoto=new ActionItem();
        itemPhoto.setItemName("相册选择");
        itemPhoto.setItemType(2);
        list.add(itemPhoto);

        new ActionSheetDialog(mView.getActivity())
                .builder()
                //.setTitle("图片")
                .setCancelable(true)
                .setCanceledOnTouchOutside(true)
                //.setItemTextColor("#FA4A46")
                .showSelectIcon(false)
                .setOnSheetItemClickListener(new ActionSheetDialog.OnSheetItemClickListener() {
                    @Override
                    public void onItemClick(ActionItem data, int which) {
                        tokePhotoByCamera(data.getItemType());
                    }
                }).setSheetItems(list).show();
    }

    @Override
    public void showTipDialog(int uploadType){
        final Dialog dialog = new Dialog(mView.getActivity(), R.style.AlertDialogStyle);
        LayoutInflater inflater = mView.getActivity().getLayoutInflater();
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
}
