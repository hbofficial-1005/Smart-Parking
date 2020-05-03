package kz.qrscan.qrscanner.Activity;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;


public class show {
    @SerializedName("status")
    private ArrayList<String> status;

    public ArrayList<String> getShow(){ return status;}
    public void setShow(ArrayList<String> status) {
        this.status = status;
    }
}
