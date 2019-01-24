package bean;


import java.io.Serializable;

/**
 * Created by 7du-28 on 2017/6/10.
 */

public class DefaultEventEntity<T> implements Serializable {

    public int what;
    public T obj;

    public DefaultEventEntity() {
        super();
    }

    public DefaultEventEntity(int what) {
        super();
        this.what = what;
    }

    public DefaultEventEntity(int what, T t) {
        super();
        this.what = what;
        this.obj = t;
    }
}
