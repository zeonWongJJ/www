package app.vdao.qidu.plugin;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.text.format.DateUtils;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;

import com.app.base.bean.FranchiseesBean;
import com.app.base.webview.PluginAction;
import com.app.base.widget.VirtualKeyboardView;
import com.bigkoo.pickerview.OptionsPickerView;
import com.bigkoo.pickerview.TimePickerView;
import com.bigkoo.pickerview.listener.CustomListener;
import com.common.lib.utils.TimeUtil;

import org.apache.cordova.CordovaWebView;
import org.apache.cordova.api.CallbackContext;
import org.apache.cordova.api.CordovaInterface;
import org.apache.cordova.api.CordovaPlugin;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import app.vdao.qidu.R;
import app.vdao.qidu.activity.CordovaHomeActivity;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Map;
import java.util.TimeZone;


public class FranchiseesPlugin extends CordovaPlugin {

    private String TAG=this.getClass().getSimpleName();
    public Activity activity;
    private CordovaHomeActivity mainCordovaActivity;
    public CordovaWebView appView;
    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        super.initialize(cordova, webView);

        if(cordova.getActivity() instanceof Activity){
            this.activity= cordova.getActivity();
            this.appView=webView;
        }
        if(cordova.getActivity() instanceof CordovaHomeActivity){
            this.mainCordovaActivity= (CordovaHomeActivity) cordova.getActivity();
            this.appView=webView;
        }
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public boolean execute(String action, JSONArray array,final CallbackContext callbackContext) throws JSONException {
        Log.i(TAG,"action:"+action);
        Log.i(TAG,"js返回内容"+array.toString());

        if(action.equals(PluginAction.ACTION_BUSINESS_LICENCE_TERM_OF_VALIDITY)) {
            this.mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //面积限制小数点开头
                    showYearMonthDayPicker(callbackContext);
                }
            });
        }else if(action.equals(PluginAction.ACTION_FRANCHISEES_CUSTOMER_ACREAGE_FLOOR)){
            JSONObject object= (JSONObject) array.get(0);
            final int type=object.getInt("clickType");//1,2,3
            final String customers=object.getString("customer");
            final String acreage=object.getString("acreage");
            final String floor=object.getString("floor");

            this.mainCordovaActivity.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //面积限制小数点开头
                    initCustomOptionPicker(callbackContext,type, customers,acreage,floor);
                }
            });
        }

        return true;
    }
    //onActivityResult为第二个Activity执行完后的回调接收方法
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent){
        switch (resultCode) { //resultCode为回传的标记，我在第二个Activity中回传的是RESULT_OK
            case Activity.RESULT_OK:
                Bundle b=intent.getExtras();  //data为第二个Activity中回传的Intent
                String str=b.getString("change01");//str即为回传的值
                break;
            default:
                break;
        }
    }

    private OptionsPickerView pvCustomOptions;
    private int handleType;
    private int customersCountType=1,acreageType=2,floorCountType=3;
    private String customersCountStr,acreageStr,floorCountStr;
    private TextView customersCountValue,floorCountValue;
    private TextView acreageValue,tvTitle,acreageTitle,text_unite;
    private View acreage_line;
    private ArrayList<Map<String, String>> valueList;
    private View layoutPickerViewCustomOptions,layoutAcreageParent;
    private CallbackContext mCallbackContext;
    private List<FranchiseesBean> customersList,floorCountList;
    private void initCustomOptionPicker(CallbackContext callbackContext,int type,String customersStr,String strAcreage,String floorStr) {//条件选择器初始化，自定义布局
        mCallbackContext=callbackContext;
        customersCountStr=customersStr;
        acreageStr=strAcreage;
        floorCountStr=floorStr;
        //Log.i("bbbbbbbb","======="+customersCountStr+acreageStr+floorCountStr);
        this.handleType=type;
        customersList=new ArrayList<>();
        customersList.add(new FranchiseesBean(0, "500以下"));
        customersList.add(new FranchiseesBean(1, "500-1000"));
        customersList.add(new FranchiseesBean(2, "1000-1500"));
        customersList.add(new FranchiseesBean(3, "1500-2000"));
        customersList.add(new FranchiseesBean(4, "2000-2500"));
        customersList.add(new FranchiseesBean(5, "2500-3000"));
        customersList.add(new FranchiseesBean(6, "3000-3500"));
        customersList.add(new FranchiseesBean(7, "3500-4000"));
        customersList.add(new FranchiseesBean(8, "4000以上"));


        floorCountList=new ArrayList<>();
        int startFloor=-3;
        for(int i=0;i<(30+startFloor);i++){
            if(i!=3){
                floorCountList.add(new FranchiseesBean(i, "第"+(i+startFloor)+"层"));
            }
        }

        /**
         * @description
         *
         * 注意事项：
         * 自定义布局中，id为 optionspicker 或者 timepicker 的布局以及其子控件必须要有，否则会报空指针。
         * 具体可参考demo 里面的两个自定义layout布局。
         */
        pvCustomOptions = new OptionsPickerView.Builder(mainCordovaActivity, new OptionsPickerView.OnOptionsSelectListener() {
            @Override
            public void onOptionsSelect(int options1, int option2, int options3, View v) {
                if(handleType==customersCountType){
                    String tx = customersList.get(options1).getPickerViewText();
                    if(customersCountValue!=null){
                        customersCountValue.setText(tx);
                        customersCountStr=tx;
                        changeButtonState();
                    }
                }else if(handleType==floorCountType){
                    String tx = floorCountList.get(options1).getPickerViewText();
                    if(floorCountValue!=null){
                        floorCountValue.setText(tx);
                        floorCountStr=tx;
                        changeButtonState();
                    }
                }
            }
        }).setLayoutRes(R.layout.layout_picker_franchisees, new CustomListener() {
                    @Override
                    public void customLayout(View v) {
                        final TextView tvSubmit = (TextView) v.findViewById(R.id.tv_finish);
                        ImageView ivCancel = (ImageView) v.findViewById(R.id.iv_cancel);
                        tvSubmit.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                pvCustomOptions.returnData();

                            }
                        });

                        ivCancel.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                //pvCustomOptions.dismiss();
                            }
                        });


                    }
                })
                //.isDialog(true)//是否弹窗
                //.setTitleText("请选择楼层")
                .setContentTextSize(20)//设置滚轮文字大小
                .setDividerColor(Color.RED)//设置分割线的颜色
                .setSelectOptions(0, 1)//默认选中项
                //.setBgColor(Color.BLACK)
                /*.setTitleBgColor(Color.DKGRAY)
                .setTitleColor(Color.LTGRAY)
                .setCancelColor(Color.YELLOW)
                .setSubmitColor(Color.YELLOW)*/
                .setTextColorCenter(Color.BLACK)
                .isCenterLabel(false) //是否只显示中间选中项的label文字，false则每项item全部都带有label。
                .setBackgroundId(0x80000000) //设置外部遮罩颜色
                .build();
        layoutPickerViewCustomOptions=pvCustomOptions.findViewById(R.id.layout_pickerview_custom_options);
        layoutAcreageParent=pvCustomOptions.findViewById(R.id.layout_acreage_parent);
        tvTitle=(TextView) pvCustomOptions.findViewById(R.id.tv_title);
        acreageTitle= (TextView) pvCustomOptions.findViewById(R.id.acreage_title);
        //人流量
        View layoutCustomersCount=pvCustomOptions.findViewById(R.id.layout_customers_count);
        customersCountValue=(TextView) pvCustomOptions.findViewById(R.id.customers_count_value);
        customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
        customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);
        layoutCustomersCount.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                handleType=customersCountType;
                pvCustomOptions.setPicker(customersList);//添加数据
                clickButtonState();
            }
        });
        //面积
        View layoutAcreage=pvCustomOptions.findViewById(R.id.layout_acreage);
        layoutAcreage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                handleType=acreageType;
                clickButtonState();
            }
        });
        acreageValue=(TextView) pvCustomOptions.findViewById(R.id.acreage_value);
        text_unite=(TextView)pvCustomOptions.findViewById(R.id.text_unite);
        acreage_line=pvCustomOptions.findViewById(R.id.acreage_line);
        View acreageFinish=pvCustomOptions.findViewById(R.id.acreage_finish);
        acreageFinish.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //确定
                String tx=acreageValue.getText().toString().trim();
                if(TextUtils.isEmpty(tx)){
                    acreageTitle.setText("面积不能为空");
                    return;
                }
                acreageStr=tx;
                /*Toast.makeText(mainCordovaActivity,""+acreageStr,Toast.LENGTH_SHORT).show();*/
                changeButtonState();
            }
        });
        VirtualKeyboardView virtualKeyboardView= (VirtualKeyboardView) pvCustomOptions.findViewById(R.id.virtual_keyboard_view);
        virtualKeyboardView.getLayoutBack().setVisibility(View.GONE);
        virtualKeyboardView.getLine().setVisibility(View.GONE);

        GridView gridView = virtualKeyboardView.getGridView();
        gridView.setOnItemClickListener(onItemClickListener);
        valueList = virtualKeyboardView.getValueList();


        //所处楼层
        View layoutFloorCount=pvCustomOptions.findViewById(R.id.layout_floor_count);
        floorCountValue=(TextView) pvCustomOptions.findViewById(R.id.floor_count_value);
        layoutFloorCount.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                handleType=floorCountType;
                pvCustomOptions.setPicker(floorCountList);//添加数据
                clickButtonState();
            }
        });

        if(!TextUtils.isEmpty(customersCountStr)){
            customersCountValue.setText(customersCountStr);
        }
        if(!TextUtils.isEmpty(acreageStr)){
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            acreageValue.setText(acreageStr);
        }
        if(!TextUtils.isEmpty(floorCountStr)){
            floorCountValue.setText(floorCountStr);
        }
        if(handleType==customersCountType){
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
            pvCustomOptions.setPicker(customersList);//添加数据
            if(tvTitle!=null){
                tvTitle.setText("请选择");//请选择人流量
            }
        }else if(handleType==floorCountType){
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
            pvCustomOptions.setPicker(floorCountList);//添加数据
            if(tvTitle!=null){
                tvTitle.setText("请选择楼层");//
            }
        }else {
            if(acreageTitle!=null){
                acreageTitle.setText("请输入面积");//
            }
            layoutPickerViewCustomOptions.setVisibility(View.GONE);
            layoutAcreageParent.setVisibility(View.VISIBLE);
        }
        clickButtonState();
        pvCustomOptions.show();

    }

    private void clickButtonState(){
        if(handleType==customersCountType){
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
        }else if(handleType==acreageType){
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            acreage_line.setVisibility(View.VISIBLE);
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);

            layoutPickerViewCustomOptions.setVisibility(View.GONE);
            layoutAcreageParent.setVisibility(View.VISIBLE);
        }else if(handleType==floorCountType){

            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
        }
    }
    //判断
    private void changeButtonState(){
        ///customersCountStr!=null&&floorCountStr!=null&&acreageStr!=null
        if(!TextUtils.isEmpty(customersCountStr)&&!TextUtils.isEmpty(floorCountStr)&&!TextUtils.isEmpty(acreageStr)){
            JSONObject jsonObject=new JSONObject();
            try {

                jsonObject.put("customer",customersCountStr);
                jsonObject.put("acreage",acreageStr);
                jsonObject.put("floor",floorCountStr);
                mCallbackContext.success(jsonObject.toString());
                pvCustomOptions.dismiss();
            } catch (JSONException e) {
                e.printStackTrace();
            }

        }else if(TextUtils.isEmpty(customersCountStr)){
            if(tvTitle!=null){
                tvTitle.setText("请选择");
            }
            pvCustomOptions.setPicker(customersList);//添加数据
            handleType=customersCountType;
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
        }else if(TextUtils.isEmpty(acreageStr)){
            if(acreageTitle!=null){
                acreageTitle.setText("请输入面积");
            }
            handleType=acreageType;
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            acreage_line.setVisibility(View.VISIBLE);
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);

            layoutPickerViewCustomOptions.setVisibility(View.GONE);
            layoutAcreageParent.setVisibility(View.VISIBLE);
        }else if(TextUtils.isEmpty(floorCountStr)){
            if(tvTitle!=null){
                tvTitle.setText("请选择楼层");
            }
            pvCustomOptions.setPicker(floorCountList);
            handleType=floorCountType;
            floorCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
            floorCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,R.drawable.line_yellow_buttom);
            customersCountValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            customersCountValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);
            /*acreageValue.setHintTextColor(mainCordovaActivity.getResources().getColor(R.color.gray));
            acreageValue.setCompoundDrawablesWithIntrinsicBounds(0,0,0,0);*/
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            layoutAcreageParent.setVisibility(View.GONE);
            layoutPickerViewCustomOptions.setVisibility(View.VISIBLE);
        }
    }
    private AdapterView.OnItemClickListener onItemClickListener = new AdapterView.OnItemClickListener() {

        @Override
        public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {
            if (position == 11) {      //点击退格键
                String amount = acreageValue.getText().toString().trim();
                if (amount.length() > 0) {
                    amount = amount.substring(0, amount.length() - 1);
                    acreageValue.setText(amount);
                    acreageStr=acreageValue.getText().toString();
                }else {
                    text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.yellow_line_color));
                    acreage_line.setVisibility(View.VISIBLE);
                }
            }
            if(acreageValue.getText().toString().trim().length()>8){//大于十个字符不让输入了
                return;
            }
            text_unite.setTextColor(mainCordovaActivity.getResources().getColor(R.color.black));
            acreage_line.setVisibility(View.GONE);
            if (position < 11 && position != 9) {    //点击0~9按钮
                String amount = acreageValue.getText().toString().trim();
                amount = amount + valueList.get(position).get("name");
                acreageValue.setText(amount);
                acreageStr=acreageValue.getText().toString();
            } else {
                if (position == 9) {      //点击退格键
                    String amount = acreageValue.getText().toString().trim();
                    if (!amount.contains(".")) {
                        amount = amount + valueList.get(position).get("name");
                        acreageValue.setText(amount);
                        acreageStr=acreageValue.getText().toString();
                        /*Editable ea = textAmount.getText();
                        textAmount.setSelection(ea.length());*/
                    }

                    if(amount.startsWith(".")){
                        amount = "0" + valueList.get(position).get("name");
                        acreageValue.setText(amount);
                    }
                }
                /*if (position == 11) {      //点击退格键
                    String amount = acreageValue.getText().toString().trim();
                    if (amount.length() > 0) {
                        amount = amount.substring(0, amount.length() - 1);
                        acreageValue.setText(amount);
                        acreageStr=acreageValue.getText().toString();

                        *//*Editable ea = textAmount.getText();
                        textAmount.setSelection(ea.length());*//*
                    }
                }*/
            }
        }
    };






    private TimePickerView pvTime;
    //营业执照有效期年月日选择
    private void showYearMonthDayPicker(final CallbackContext callbackContext) {
        final Calendar c = Calendar.getInstance();
        c.setTimeZone(TimeZone.getTimeZone("GMT+8:00"));
        int currentYear = c.get(Calendar.YEAR);// 获取当前年份
        Log.i("aaaaaa","currentYear"+currentYear);
        //int currentMonth = c.get(Calendar.MONTH) + 1;// 获取当前月份
        int currentMonth = c.get(Calendar.MONTH);
        int currentDay = c.get(Calendar.DAY_OF_MONTH);
        //控制时间范围(如果不设置范围，则使用默认时间1900-2100年，此段代码可注释)
        //因为系统Calendar的月份是从0-11的,所以如果是调用Calendar的set方法来设置时间,月份的范围也要是从0-11
        //Calendar selectedDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));
        Calendar startDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));
        //Log.i("aaaaaa","currentYear"+currentYear+"currentMonth"+currentMonth+"currentDay"+currentDay);
        //currentYear2017currentMonth12currentDay28
        startDate.set(currentYear, currentMonth, currentDay);
        Calendar endDate = Calendar.getInstance(TimeZone.getTimeZone("GMT+8:00"));
        endDate.set(currentYear+50, 11, 30);
        //时间选择器
        pvTime = new TimePickerView.Builder(this.mainCordovaActivity, new TimePickerView.OnTimeSelectListener() {
            @Override
            public void onTimeSelect(Date date, View v) {//选中事件回调
                long timeStamp = date.getTime();
                JSONObject object=new JSONObject();
                try {
                    object.put("timeStamp",timeStamp);
                    object.put("timeFormat", TimeUtil.getTimeFormatByDate(date,"yyyy年MM月dd日"));
                    callbackContext.success(object.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        })/*.setLayoutRes()*/
                //年月日时分秒 的显示与否，不设置则默认全部显示
                .setType(new boolean[]{true, true, true, false, false, false})
                .setLabel("年", "月", "日", "", "", "")
                .setTitleText("请选择营业执照有效期")
                .setSubmitColor(Color.RED)
                .setCancelColor(Color.RED)
                .isCenterLabel(false)
                .setDividerColor(Color.RED)
                .setContentSize(21)
                .setDate(startDate)
                .setRangDate(startDate, endDate)
                .setBackgroundId(0x80000000) //设置外部遮罩颜色  80000000
                .build();
        //Log.i("aaaaaa","currentYear"+DateUtils.getTimeFormatByDate(startDate,"yyyy年MM月dd日"));
        pvTime.show();
    }
}
