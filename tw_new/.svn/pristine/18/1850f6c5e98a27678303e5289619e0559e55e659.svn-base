package com.app.base.utils;


import android.content.Context;
import android.content.res.Resources;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Build;
import android.view.Gravity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.NumberPicker;
import android.widget.TimePicker;


import com.app.base.R;

import java.lang.reflect.Field;
import java.util.ArrayList;
import java.util.List;
public class NumberPickerUtil {
    public NumberPickerUtil() {
    }


    /**
     * @param picker 传入一个DatePicker对象,隐藏或者显示相应的时间项
     */
    public void hideDayPicker(DatePicker picker) {
        // 利用java反射技术得到picker内部的属性，并对其进行操作
        Class<? extends DatePicker> c = picker.getClass();
        try {
            Field fd = null, fm = null, fy = null;
            // 系统版本大于5.0
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                int daySpinnerId = Resources.getSystem().getIdentifier("day", "id", "android");
                if (daySpinnerId != 0) {
                    View daySpinner = picker.findViewById(daySpinnerId);
                    if (daySpinner != null) {
                        daySpinner.setVisibility(View.GONE);
                        return;
                    }
                }
            } else if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.ICE_CREAM_SANDWICH) {
                // 系统版本大于4.0
                fd = c.getDeclaredField("mDaySpinner");
                fm = c.getDeclaredField("mMonthSpinner");
                fy = c.getDeclaredField("mYearSpinner");
            } else {
                fd = c.getDeclaredField("mDayPicker");
                fm = c.getDeclaredField("mMonthPicker");
                fy = c.getDeclaredField("mYearPicker");
            }
            // 对字段获取设置权限
            fd.setAccessible(true);
            fm.setAccessible(true);
            fy.setAccessible(true);
            // 得到对应的控件
            View vd = (View) fd.get(picker);
            View vm = (View) fm.get(picker);
            View vy = (View) fy.get(picker);

            vd.setVisibility(View.GONE);
            vm.setVisibility(View.VISIBLE);
            vy.setVisibility(View.VISIBLE);
        } catch (NoSuchFieldException e) {
            e.printStackTrace();
        } catch (IllegalArgumentException e) {
            e.printStackTrace();
        } catch (IllegalAccessException e) {
            e.printStackTrace();
        }
    }
        /**
         * 设置时间选择器的分割线颜色
         *
         * @param datePicker
         */
    public void setDatePickerDividerColor(Context context,DatePicker datePicker) {
        // Divider changing:

        // 获取 mSpinners
        LinearLayout llFirst = (LinearLayout) datePicker.getChildAt(0);

        // 获取 NumberPicker
        LinearLayout mSpinners = (LinearLayout) llFirst.getChildAt(0);
        for (int i = 0; i < mSpinners.getChildCount(); i++) {
            NumberPicker picker = (NumberPicker) mSpinners.getChildAt(i);

            Field[] pickerFields = NumberPicker.class.getDeclaredFields();
            for (Field pf : pickerFields) {
                if (pf.getName().equals("mSelectionDivider")) {
                    pf.setAccessible(true);
                    try {
                        pf.set(picker, new ColorDrawable(context.getResources().getColor(R.color.blue)));//设置分割线颜色
                    } catch (IllegalArgumentException e) {
                        e.printStackTrace();
                    } catch (Resources.NotFoundException e) {
                        e.printStackTrace();
                    } catch (IllegalAccessException e) {
                        e.printStackTrace();
                    }
                    break;
                }
            }
        }
    }


    public void setNumberPickerDividerColor(Context context, NumberPicker numberPicker) {
        NumberPicker picker = numberPicker;
        Field[] pickerFields = NumberPicker.class.getDeclaredFields();
        for (Field pf : pickerFields) {
            if (pf.getName().equals("mSelectionDivider")) {
                pf.setAccessible(true);
                try {
                    //设置分割线的颜色值
                    pf.set(picker, new ColorDrawable(context.getResources().getColor(R.color.blue)));
                } catch (IllegalArgumentException e) {
                    e.printStackTrace();
                } catch (Resources.NotFoundException e) {
                    e.printStackTrace();
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                }
                break;
            }
        }
    }


    /*
         * 调整大小
         */
    private void resizeNumberPicker(NumberPicker np) {
        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(280, LinearLayout.LayoutParams.WRAP_CONTENT);
        params.setMargins(10, 0, 10, 0);
        np.setLayoutParams(params);
    }


    private List<NumberPicker> findNumberPicker(ViewGroup viewGroup) {
        List<NumberPicker> npList = new ArrayList<NumberPicker>();
        View child = null;

        if (null != viewGroup) {
            for (int i = 0; i < viewGroup.getChildCount(); i++) {
                child = viewGroup.getChildAt(i);
                if (child instanceof NumberPicker) {
                    npList.add((NumberPicker) child);
                } else if (child instanceof LinearLayout) {
                    List<NumberPicker> result = findNumberPicker((ViewGroup) child);
                    if (result.size() > 0) {
                        return result;
                    }
                }
            }
        }

        return npList;
    }

    private EditText findEditText(NumberPicker np) {
        if (null != np) {
            for (int i = 0; i < np.getChildCount(); i++) {
                View child = np.getChildAt(i);

                if (child instanceof EditText) {
                    return (EditText) child;
                }
            }
        }

        return null;
    }

    private void setNumberPickerTextSize(ViewGroup viewGroup) {
        List<NumberPicker> npList = findNumberPicker(viewGroup);
        if (null != npList) {
            for (NumberPicker np : npList) {
                EditText et = findEditText(np);
                et.setFocusable(false);
                et.setGravity(Gravity.CENTER);
                et.setTextSize(10);

            }
        }
    }


    private void resizeTimerPicker(TimePicker tp) {
        List<NumberPicker> npList = findNumberPicker(tp);

        for (NumberPicker np : npList) {
            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(100, LinearLayout.LayoutParams.WRAP_CONTENT);
            params.setMargins(10, 0, 10, 0);
            np.setLayoutParams(params);

        }
    }
}
