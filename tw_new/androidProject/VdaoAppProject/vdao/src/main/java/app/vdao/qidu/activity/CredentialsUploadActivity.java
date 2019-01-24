package app.vdao.qidu.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.utils.IntentParams;
import com.bumptech.glide.Glide;
import com.common.lib.utils.ToastUtils;
import com.mvp.lib.base.BaseActivity;
import com.net.rx_retrofit_network.location.retrofit.RetrofitUtil;

import org.json.JSONException;
import org.json.JSONObject;
import app.vdao.qidu.R;
import app.vdao.qidu.mvp.contract.CredentialsUploadContract;
import app.vdao.qidu.mvp.presenter.CredentialsUploadPresenterImpl;

/**
 * 证件上传--身份证/营业执照
 */

public class CredentialsUploadActivity extends BaseActivity<CredentialsUploadPresenterImpl> implements View.OnClickListener,CredentialsUploadContract.View{

    public static int CREDENTIALS_RESULT_CODE=0x147;
    public static int CREDENTIALS_REQUEST_CODE=0x741;
    private int BUSINESS_LICENSE_TYPE=1;//business_license
    private int IDENTITY_TYPE=2;//identity
    private int uploadType;

    private View layout_business_license,layout_identity_card,take_photo_tip;

    private ImageView identity_positive;
    private ImageView identity_positive_btn;

    private ImageView identity_native;
    private ImageView identity_native_btn;
    private ImageView business_license;
    private ImageView business_license_btn;

    private String identity_positive_url="",identity_native_url="",business_license_url="";



    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        uploadType=getIntent().getIntExtra(IntentParams.KEY_CREDENTIALS_TYPE,0);
        business_license_url=getIntent().getStringExtra(IntentParams.KEY_BUSINESS_LICENSE_URL);
        identity_positive_url=getIntent().getStringExtra(IntentParams.KEY_IDENTITY_POSITIVE_URL);
        identity_native_url=getIntent().getStringExtra(IntentParams.KEY_IDENTITY_NATIVE_URL);
        headTitle=findView(R.id.header_text);
        headBack=findView(R.id.header_left_btn_img);
        TextView titleTypeValue=findView(R.id.title_type_value);
        layout_business_license=findView(R.id.layout_business_license);
        layout_identity_card=findView(R.id.layout_identity_card);
        identity_positive=findView(R.id.identity_positive);
        identity_positive_btn=findView(R.id.identity_positive_btn);
        identity_native=findView(R.id.identity_native);
        identity_native_btn=findView(R.id.identity_native_btn);
        business_license=findView(R.id.business_license);
        business_license_btn=findView(R.id.business_license_btn);
        take_photo_tip=findView(R.id.take_photo_tip);

        identity_positive_btn.setOnClickListener(this);
        identity_native_btn.setOnClickListener(this);
        business_license_btn.setOnClickListener(this);
        take_photo_tip.setOnClickListener(this);
        headBack.setOnClickListener(this);
        if(uploadType==BUSINESS_LICENSE_TYPE){
            headTitle.setText("营业执照");
            titleTypeValue.setText("上传营业执照");
            layout_identity_card.setVisibility(View.GONE);
            layout_business_license.setVisibility(View.VISIBLE);
            if(!TextUtils.isEmpty(business_license_url)){
                Glide.with(getActivity()).load(RetrofitUtil.DEFAULT_HOST+business_license_url).into(business_license);
            }
        }else if(uploadType==IDENTITY_TYPE){
            headTitle.setText("身份证");
            titleTypeValue.setText("上传身份证");
            layout_business_license.setVisibility(View.GONE);
            layout_identity_card.setVisibility(View.VISIBLE);
            if(!TextUtils.isEmpty(identity_positive_url)){
                Glide.with(getActivity()).load(RetrofitUtil.DEFAULT_HOST+identity_positive_url).into(identity_positive);
            }
            if(!TextUtils.isEmpty(identity_native_url)){
                Glide.with(getActivity()).load(RetrofitUtil.DEFAULT_HOST+identity_native_url).into(identity_native);
            }


        }
        mPresenter.showTipDialog(uploadType);
    }

/*Intent intent=new Intent();
                    intent.putExtra("","");
                    setResult(0x147,intent);
                    finish();*/


    @Override
    public void uploadSuccess(String path,String url) {
        if(clickView==identity_positive_btn){
            identity_positive_url=url;
            Glide.with(getActivity()).load(path).into(identity_positive);
        }else if(clickView==identity_native_btn){
            identity_native_url=url;
            Glide.with(getActivity()).load(path).into(identity_native);
        }else if(clickView==business_license_btn){
            business_license_url=url;
            Glide.with(getActivity()).load(path).into(business_license);
        }

    }

    private View clickView;
    @Override
    public void onClick(View view) {
        clickView=view;
        int id=view.getId();
        if(id==R.id.identity_positive_btn){
            mPresenter.takePhotoPicker();
        }else if(id==R.id.identity_native_btn){
            mPresenter.takePhotoPicker();
        } else if (id==R.id.business_license_btn) {
            mPresenter.takePhotoPicker();
        }else if(id==R.id.take_photo_tip){
            mPresenter.showTipDialog(uploadType);
        }else if(id==R.id.header_left_btn_img){
            setResult();
            finish();
        }
    }

    private void setResult(){
        if(uploadType==BUSINESS_LICENSE_TYPE&& !TextUtils.isEmpty(business_license_url)){
            JSONObject jsonObject=new JSONObject();
            try {
                jsonObject.put("business_license_url",business_license_url);
                //jsonObject.put("identity_positive_url","");
                //jsonObject.put("identity_native_url","");
            } catch (JSONException e) {
                e.printStackTrace();
            }
            Intent intent=new Intent();
            intent.putExtra(IntentParams.KEY_CREDENTIALS_URL,jsonObject.toString());
            setResult(CREDENTIALS_RESULT_CODE,intent);
        }else if(uploadType==IDENTITY_TYPE&&(!TextUtils.isEmpty(identity_positive_url)||!TextUtils.isEmpty(identity_native_url))){
            JSONObject jsonObject=new JSONObject();
            try {
                //jsonObject.put("business_license_url","");
                jsonObject.put("identity_positive_url",identity_positive_url);
                jsonObject.put("identity_native_url",identity_native_url);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            Intent intent=new Intent();
            intent.putExtra(IntentParams.KEY_CREDENTIALS_URL,jsonObject.toString());
            setResult(CREDENTIALS_RESULT_CODE,intent);
        }
    }


    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if(keyCode == KeyEvent.KEYCODE_BACK && event.getAction() == KeyEvent.ACTION_DOWN){
            setResult();
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.activity_credentials_upload, null);
        return view;
    }

    @Override
    protected CredentialsUploadPresenterImpl initPresenter() {
        return new CredentialsUploadPresenterImpl();
    }
    @Override
    public void showToast(String message) {
        ToastUtils.show(message);
    }

    @Override
    public void showLoadingDialog(String message) {
        showProgressDialog(message);
    }

    @Override
    public void dismissLoadingDialog() {
        dismissProgressDialog();
    }
}