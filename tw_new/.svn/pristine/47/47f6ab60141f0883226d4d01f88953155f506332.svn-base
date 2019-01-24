package app.odp.qidu.activity;

import android.content.Intent;
import android.content.res.Resources;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.DatePicker;
import android.widget.ImageView;
import android.widget.NumberPicker;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.app.base.bean.Participant;
import com.app.base.bean.UserRealm;
import com.app.base.netUtil.MemberHttpUtil;
import com.app.base.utils.DataUtils;
import com.app.base.utils.IntentParams;
import com.app.base.utils.NumberPickerUtil;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.StatusBarUtil;
import com.luck.picture.lib.immersive.LightStatusBarUtils;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 *时间选择 https://blog.csdn.net/u012246458/article/details/49800271
 */

public class TimePickerActivity extends AbsBaseActivity implements NumberPicker.OnValueChangeListener {

    private DatePicker datePicker;
    private NumberPicker department_picker,personnel_picker;
    private List<Participant> list;
    private TextView btn_change,show_select;
    private View participant_layout;
    public static int ONLY_SHOW_DATE_CHOOSE=1;//日历选择
    public static int WHOLE_DATE_CHOOSE=2;//日历时间选择  全部
    public static int ONLY_SHOW_DEPARTMENT=0;//选择部门人员

    public boolean isHideDay=false;//ONLY_SHOW_DATE_CHOOSE下，是否隐藏日显示
    public boolean isLimitDate=false;//默认不限制，限制的话最大时间是当前年月日
    private int type;
    private TimePicker timePicker;
    private int hour,mMinute;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_time_picker);
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        isHideDay=getIntent().getBooleanExtra(IntentParams.KEY_DATE_PICKER_IS_HIDE_DAY,false);
        isLimitDate=getIntent().getBooleanExtra(IntentParams.KEY_IS_LIMIT_DATE,false);
        type=getIntent().getIntExtra(IntentParams.KEY_DATE_PICKER_DEPARTMENT_PICKER,0);
        View layout_parent=findViewById(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setTextColor(getResources().getColor(R.color.black));
        TextView right= (TextView) findViewById(R.id.title_right_text);
        right.setTextColor(getResources().getColor(R.color.blue));
        right.setText("完成");

        ImageView back= (ImageView) findViewById(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        show_select= (TextView) findViewById(R.id.show_select);
        participant_layout=findViewById(R.id.participant_layout);
        btn_change= (TextView) findViewById(R.id.btn_change);
        department_picker= (NumberPicker) findViewById(R.id.department_picker);
        personnel_picker= (NumberPicker) findViewById(R.id.personnel_picker);

        datePicker = (DatePicker) findViewById(R.id.dp_picker);
        timePicker = (TimePicker) findViewById(R.id.time_picker);
        timePicker.setIs24HourView(true);

        timePicker.setOnTimeChangedListener(new TimePicker.OnTimeChangedListener() {
            @Override
            public void onTimeChanged(TimePicker view, int hourOfDay, int minute) {
                hour=hourOfDay;
                mMinute=minute;
                Calendar calendar = Calendar.getInstance();
                calendar.set(datePicker.getYear(), datePicker.getMonth(), datePicker.getDayOfMonth(),hour,mMinute);
                SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm");
                //Toast.makeText(getActivity(),format.format(calendar.getTime()), Toast.LENGTH_SHORT).show();
                show_select.setText(format.format(calendar.getTime()));
            }
        });
        NumberPickerUtil pickerUtil=new NumberPickerUtil();

        if(type==ONLY_SHOW_DATE_CHOOSE){
            titleCenter.setText("选择时间");
            btn_change.setText("按时间选择");
            participant_layout.setVisibility(View.GONE);
            datePicker.setVisibility(View.VISIBLE);
            pickerUtil.setDatePickerDividerColor(getActivity(),datePicker);
            Calendar c = Calendar.getInstance();//
            int mYear = c.get(Calendar.YEAR); // 获取当前年份
            int mMonth = c.get(Calendar.MONTH) + 1;// 获取当前月份
            int mDay = c.get(Calendar.DAY_OF_MONTH);// 获取当日期
            if(isLimitDate){
                long currentMillions=System.currentTimeMillis();
                datePicker.setMaxDate(currentMillions);
            }
            //datePicker.setMinDate(currentMillions-10*365*24*60*60);//往后约10年
            //NumberPicker
            datePicker.init(mYear, mMonth, mDay, new DatePicker.OnDateChangedListener() {
                @Override
                public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                    // 获取一个日历对象，并初始化为当前选中的时间
                    Calendar calendar = Calendar.getInstance();
                    calendar.set(year, monthOfYear, dayOfMonth);
                    SimpleDateFormat format=null;
                    if(isHideDay){
                        format = new SimpleDateFormat("yyyy-MM");
                    }else {
                        format = new SimpleDateFormat("yyyy-MM-dd");
                    }
                    //Toast.makeText(getActivity(),format.format(calendar.getTime()), Toast.LENGTH_SHORT).show();
                    show_select.setText(format.format(calendar.getTime()));
                }
            });
            if(isHideDay&&datePicker != null){//显示年月，不显示日
                //((ViewGroup) datePicker.getChildAt(0)).getChildAt(2).setVisibility(View.GONE);
                pickerUtil.hideDayPicker(datePicker);
            }
        }else if(type==WHOLE_DATE_CHOOSE){
            titleCenter.setText("选择时间");
            btn_change.setText("按时间选择");
            participant_layout.setVisibility(View.GONE);
            datePicker.setVisibility(View.VISIBLE);
            timePicker.setVisibility(View.VISIBLE);
            pickerUtil.setDatePickerDividerColor(getActivity(),datePicker);
            Calendar c = Calendar.getInstance();//
            int mYear = c.get(Calendar.YEAR); // 获取当前年份
            int mMonth = c.get(Calendar.MONTH);// 获取当前月份
            int mDay = c.get(Calendar.DAY_OF_MONTH);// 获取当日期
            datePicker.init(mYear, mMonth, mDay, new DatePicker.OnDateChangedListener() {
                @Override
                public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                    // 获取一个日历对象，并初始化为当前选中的时间
                    Calendar calendar = Calendar.getInstance();
                    calendar.set(datePicker.getYear(), datePicker.getMonth(), datePicker.getDayOfMonth(),hour,mMinute);
                    SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm");
                    show_select.setText(format.format(calendar.getTime()));
                }
            });
            Resources systemResources = Resources.getSystem();
            int hourNumberPickerId = systemResources.getIdentifier("hour", "id", "android");
            int minuteNumberPickerId = systemResources.getIdentifier("minute", "id", "android");
            NumberPicker hourNumberPicker = (NumberPicker) timePicker.findViewById(hourNumberPickerId);
            hourNumberPicker.setWrapSelectorWheel(false);//是否循环滚动
            NumberPicker minuteNumberPicker = (NumberPicker) timePicker.findViewById(minuteNumberPickerId);
            minuteNumberPicker.setWrapSelectorWheel(false);
            pickerUtil.setNumberPickerDividerColor(getActivity(),hourNumberPicker);
            pickerUtil.setNumberPickerDividerColor(getActivity(),minuteNumberPicker);

            hour=c.get(Calendar.HOUR_OF_DAY);
            mMinute=c.get(Calendar.MINUTE);

        }else if(type==ONLY_SHOW_DEPARTMENT){
            titleCenter.setText("查看他人");
            btn_change.setText("按部门选择");
            datePicker.setVisibility(View.GONE);
            participant_layout.setVisibility(View.VISIBLE);
            pickerUtil.setNumberPickerDividerColor(getActivity(),department_picker);
            pickerUtil.setNumberPickerDividerColor(getActivity(),personnel_picker);

            department_picker.setOnValueChangedListener(this);
            personnel_picker.setOnValueChangedListener(this);
            getDepartMentMembers();
        }

        right.setOnClickListener(v -> {
            if(type==ONLY_SHOW_DEPARTMENT){
                int participantPosition=department_picker.getValue();
                Participant selectParticipant=list.get(participantPosition);
                List<UserRealm> userList=selectParticipant.getUserList();
                int position = personnel_picker.getValue();
                if(userList!=null&&userList.size()>0){
                    UserRealm user=userList.get(position);
                    Intent intent=new Intent();
                    intent.putExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT,user);
                    setResult(RESULT_OK,intent);
                    finish();
                }
            }else if(type==WHOLE_DATE_CHOOSE){
                Calendar calendar = Calendar.getInstance();
                calendar.set(datePicker.getYear(), datePicker.getMonth(), datePicker.getDayOfMonth(),hour,mMinute);
                SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm");
                Intent intent=new Intent();
                intent.putExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT,format.format(calendar.getTime()));
                setResult(RESULT_OK,intent);
                finish();

            }else if(type==ONLY_SHOW_DATE_CHOOSE){
                Calendar calendar = Calendar.getInstance();
                calendar.set(datePicker.getYear(), datePicker.getMonth(), datePicker.getDayOfMonth());
                SimpleDateFormat format;
                if(isHideDay){
                    format = new SimpleDateFormat("yyyy-MM");
                }else {
                    format = new SimpleDateFormat("yyyy-MM-dd");
                }
                Intent intent=new Intent();
                intent.putExtra(IntentParams.KEY_DEPARTMENT_PERSON_SELECT,format.format(calendar.getTime()));
                setResult(RESULT_OK,intent);
                finish();
            }
        });
    }
    private String[] currentDepartment;
    private String[] currentUser;
    //设置部门数据
    private void initDepartmentData(List<Participant> participantList){
        list=participantList;
        if(list!=null&&list.size()>0){
            String[] departmentArray = new String[list.size()];
            for (int i = 0; i < departmentArray.length; i++) {
                departmentArray[i] = list.get(i).getDepartment_name()+"";
            }
            currentDepartment=departmentArray;
            //在设置最大值和最新数组数据前，先将数据设为null。
            department_picker.setDisplayedValues(null);
            department_picker.setMinValue(0);
            department_picker.setMaxValue(list.size()-1);
            department_picker.setDisplayedValues(departmentArray);
            department_picker.setWrapSelectorWheel(false);//是否循环滚动在setMaxValue()和setMinValue()后面调用
        }else {
            return;
        }
        department_picker.setValue(0);
        initPersonnelData(department_picker.getValue());
        show_select.setText(currentDepartment[0]+"-"+currentUser[0]);
    }

    //设置各部门人员

    private void initPersonnelData(int position){
        Participant selectParticipant=list.get(position);
        List<UserRealm> userList = selectParticipant.getUserList();
        if (userList != null && userList.size() > 0) {
            try {
                String[] userNames = new String[userList.size()];
                for (int i = 0; i < userNames.length; i++) {
                    String name="";
                    if(userList.get(i).getReal_name()!=null){
                        name=userList.get(i).getReal_name();
                    }else {
                        name=userList.get(i).getMember_name();
                    }
                    userNames[i] = name+"";
                }
                currentUser=userNames;
                //在设置最大值和最新数组数据前，先将数据设为null。
                personnel_picker.setDisplayedValues(null);
                personnel_picker.setMinValue(0);
                personnel_picker.setMaxValue(userList.size()-1);
                personnel_picker.setDisplayedValues(userNames);
                personnel_picker.setWrapSelectorWheel(false);
                personnel_picker.setValue(0);
            } catch (NumberFormatException e) {
            }
        }
    }

    @Override
    public void onValueChange(NumberPicker picker, int oldVal, int newVal) {
        if (department_picker.equals(picker)) {
            initPersonnelData(department_picker.getValue());
            if(currentDepartment==null||currentUser==null){
                return;
            }
            show_select.setText(currentDepartment[department_picker.getValue()]+"-"+currentUser[personnel_picker.getValue()]);
        } else if (personnel_picker.equals(picker)) {
            if(currentDepartment==null||currentUser==null){
                return;
            }
            show_select.setText(currentDepartment[department_picker.getValue()]+"-"+currentUser[personnel_picker.getValue()]);
            /*int position = personnel_picker.getValue();
            UserRealm user=userList.get(position);*/
            ///Log.i("bbbbbbbbbbb","选中的部门和名字=========="+selectParticipant.getName()+"----"+user.getName());
        }
    }


    private void getDepartMentMembers(){
        UserRealm.queryAllUserRealm(new UserRealm.QueryDbCallBack<UserRealm>() {
            @Override
            public void querySuccess(List<UserRealm> items, boolean hasMore) {
                if(items.isEmpty()){
                    getDepartmentAndMember();
                }else {
                    List<Participant> participantList = DataUtils.getParticipantGroup(items);
                    if(participantList!=null){
                        initDepartmentData(participantList);
                    }
                }
            }
        });
    }
    private void getDepartmentAndMember(){
        HashMap<String, String> hashMap=new HashMap<>();
        Disposable disposable= MemberHttpUtil.getInstance().departmentAndMembers(hashMap, new DisposableObserver<List<Participant>>() {
            @Override
            public void onNext(List<Participant> list) {
                if(list!=null){
                    initDepartmentData(list);
                }
            }
            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onComplete() {

            }
        });
    }
}
