package com.qidu.chat.widget;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.GridView;

/**
 * Created by 7du-28 on 2017/12/26.
 */

public class FullyGridView extends GridView {

    public FullyGridView(Context context) {
        super(context);
    }

    public FullyGridView(Context context, AttributeSet attrs) {
        super(context, attrs);
    }

    public FullyGridView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
    }

    @Override
    protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
        int expandSpec = MeasureSpec.makeMeasureSpec(Integer.MAX_VALUE >> 2, MeasureSpec.AT_MOST);
        super.onMeasure(widthMeasureSpec, expandSpec);
    }
}
