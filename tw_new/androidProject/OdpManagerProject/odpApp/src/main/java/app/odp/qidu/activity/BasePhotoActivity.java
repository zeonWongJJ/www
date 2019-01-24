package app.odp.qidu.activity;

import android.content.Context;
import android.content.ContextWrapper;
import android.content.Intent;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.View;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.interfaces.UploadProgressListener;
import com.app.base.bean.BaseResponse;
import com.app.base.netUtil.UploadUtil;
import com.common.lib.basemvp.base.BaseActivity;
import com.common.lib.basemvp.presenter.BasePresenter;
import com.common.lib.utils.ToastUtils;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.config.PictureConfig;
import com.luck.picture.lib.config.PictureMimeType;
import com.luck.picture.lib.entity.LocalMedia;

import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.GridImageAdapter;
import app.odp.qidu.adapter.GridImageSelectAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 图片文件选择基类
 */

public abstract class BasePhotoActivity<T extends BasePresenter> extends BaseActivity<T> {

    protected GridImageSelectAdapter imgAdapter;
    protected RecyclerView imgRecyclerView;
    private int maxSelectNum=9;


    protected void initSelectPhoto(){
        /*图片选择相关*/
        imgRecyclerView=findView(R.id.recycler_img);
        imgRecyclerView.setNestedScrollingEnabled(false);
        imgRecyclerView.setHasFixedSize(true);
        //recyclerView.addItemDecoration(new GridSpacingItemDecoration(4, ScreenUtils.dip2px(this, 2), false));
        GridLayoutManager manager = new GridLayoutManager(getActivity(), 3, GridLayoutManager.VERTICAL, false);
        imgRecyclerView.setLayoutManager(manager);
        ((DefaultItemAnimator) imgRecyclerView.getItemAnimator()).setSupportsChangeAnimations(false);
        imgAdapter = new GridImageSelectAdapter(getActivity(), onAddPicClickListener);
        imgAdapter.setReUploadListener(v -> {
            int position= (int) v.getTag();
            uploadImage(position);
        });
        imgAdapter.setSelectMax(maxSelectNum);
        imgRecyclerView.setAdapter(imgAdapter);
        imgAdapter.setOnItemClickListener(new GridImageSelectAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(int position, View v) {
                if (imgAdapter.getDataList().size() > 0) {
                    LocalMedia media = imgAdapter.getDataList().get(position);
                    String pictureType = media.getPictureType();
                    int mediaType = PictureMimeType.pictureToVideo(pictureType);
                    switch (mediaType) {
                        case 1:
                            // 预览图片 可自定长按保存路径
                            //PictureSelector.create(MainActivity.this).externalPicturePreview(position, "/custom_file", selectList);
                            PictureSelector.create(getActivity()).externalPicturePreview(position, imgAdapter.getDataList());
                            break;
                    }
                }

            }
        });
    }


    /**
     * 删除图片回调接口
     */

    private GridImageSelectAdapter.onAddPicClickListener onAddPicClickListener = new GridImageSelectAdapter.onAddPicClickListener() {
        @Override
        public void onAddPicClick(int type, int position) {
            if(type==0){
                List<LocalMedia> imgSelectList=new ArrayList<>();
                if(imgAdapter.getDataList().size()>0){
                    maxSelectNum=maxSelectNum-imgAdapter.getDataList().size();
                }
                PictureSelector.create(getActivity())
                        .openGallery(PictureMimeType.ofImage())
                        .theme(R.style.picture_default_style)
                        .maxSelectNum(maxSelectNum)
                        .enableCrop(true)
                        .minimumCompressSize(100)// 小于100kb的图片不压缩
                        .compress(true)
                        /*.theme(R.style.picture_default_style)
                        .maxSelectNum(maxSelectNum)
                        .circleDimmedLayer(false)// 是否圆形裁剪 true or false
                        .showCropFrame(true)// 是否显示裁剪矩形边框 圆形裁剪时建议设为false   true or false
                        .showCropGrid(false)// 是否显示裁剪矩形网格 圆形裁剪时建议设为false    true or false
                        .hideBottomControls(false)
                        .rotateEnabled(true) // 裁剪是否可旋转图片 true or false
                        .scaleEnabled(true)// 裁剪是否可放大缩小图片 true or false
                        .isGif(true)// 是否显示gif图片 true or false
                        .minimumCompressSize(100)// 小于100kb的图片不压缩
                        .enableCrop(true)
                        .freeStyleCropEnabled(true)// 裁剪框是否可拖拽 true or false
                        .isDragFrame(true)// 是否可拖动裁剪框(固定)
                        .compress(true)*/
                        .selectionMedia(imgSelectList)
                        .forResult(PictureConfig.CHOOSE_REQUEST);
            }else if(type==1){
                // 删除图片
                if (position != RecyclerView.NO_POSITION) {
                    if(imgAdapter.getDataList().get(position).getImageUrl()==null&& TextUtils.isEmpty(imgAdapter.getDataList().get(position).getImageUrl())){
                        AndroidNetworking.cancel(imgAdapter.getDataList().get(position).getCompressPath());
                    }
                    imgAdapter.getDataList().remove(position);
                    imgAdapter.notifyItemRemoved(position);
                    imgRecyclerView.requestLayout();
                }
            }

        }
    };



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
    /*注意，编辑任务的时候包括线上的图片地址，所以暂时无法去相册那边限制数量*/
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == RESULT_OK) {
            if (requestCode == PictureConfig.CHOOSE_REQUEST) {
                List<LocalMedia> imgSelectList = PictureSelector.obtainMultipleResult(data);
                if(imgAdapter.getDataList().size()>maxSelectNum){
                    imgAdapter.getDataList().subList(0,maxSelectNum);
                    ToastUtils.show("最多只能选择"+maxSelectNum+"张图片哦");
                }
                // 如果裁剪并压缩了，以取压缩路径为准，因为是先裁剪后压缩的
                imgAdapter.appendList(imgSelectList);
                imgAdapter.notifyDataSetChanged();

                for (int i = 0; i < imgAdapter.getDataList().size(); i++) {
                    if (imgAdapter.getDataList().get(i).getImageUrl() == null) {
                        uploadImage(i);
                    }
                }
            }
        }
    }


    /**/
    private void uploadImage(int finalI){

        Disposable disposable=UploadUtil.getInstance().uploadImg(imgAdapter.getDataList().get(finalI).getCompressPath(), new UploadProgressListener() {
            @Override
            public void onProgress(long bytesUploaded, long totalBytes) {
                double percent = (double)bytesUploaded / totalBytes;
                DecimalFormat format = new DecimalFormat("0%");
                String progress = format.format(percent);
                imgAdapter.getDataList().get(finalI).setProgress(progress);
                imgAdapter.getDataList().get(finalI).setUploadFailure(false);
                imgAdapter.getDataList().get(finalI).setUploadFinish(false);
                imgAdapter.notifyItemChanged(finalI);
            }
        }, new DisposableObserver<String>() {
            @Override
            public void onNext(String response) {
                Gson gson=new Gson();
                BaseResponse<LocalMedia> mod= gson.fromJson(response,
                        new TypeToken<BaseResponse<LocalMedia>>() {
                        }.getType());
                if(mod.getError()== BaseResponse.STATUS_SUCCESS){
                    imgAdapter.getDataList().get(finalI).setImageUrl(mod.getData().getPath());
                    imgAdapter.getDataList().get(finalI).setProgress(null);
                    imgAdapter.getDataList().get(finalI).setUploadFinish(true);
                    imgAdapter.getDataList().get(finalI).setUploadFailure(false);
                    if (imgRecyclerView.getScrollState() == RecyclerView.SCROLL_STATE_IDLE || (imgRecyclerView.isComputingLayout() == false)) {
                        imgAdapter.notifyItemChanged(finalI);
                    }
                }else {
                    ToastUtils.show(mod.getMsg());
                    imgAdapter.getDataList().get(finalI).setProgress(null);
                    imgAdapter.getDataList().get(finalI).setUploadFailure(true);
                    imgAdapter.getDataList().get(finalI).setUploadFinish(false);
                    imgAdapter.notifyItemChanged(finalI);
                }
            }

            @Override
            public void onError(Throwable e) {
                imgAdapter.getDataList().get(finalI).setProgress(null);
                imgAdapter.getDataList().get(finalI).setUploadFailure(true);
                imgAdapter.getDataList().get(finalI).setUploadFinish(false);
                imgAdapter.notifyItemChanged(finalI);
            }

            @Override
            public void onComplete() {

            }
        });
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
