package com.example.prernapadhee.wavesoft;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.icu.util.Calendar;
import android.os.Build;
import android.support.annotation.RequiresApi;
import android.support.v4.app.DialogFragment;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Main4Activity extends AppCompatActivity {

    private TextView username, email, dob, name;
    static EditText DateEdit, school, address, phoneno;
    ImageView imgProfile;
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main4);
        if (!SharedPrefManager.getInstance(this).isLoggedIn()) {

            finish();
            Intent i = new Intent(this, Main2Activity.class);
            startActivity(i);
        }

        DateEdit = (EditText) findViewById(R.id.dob);
        DateEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showTruitonDatePickerDialog(v);
            }
        });

        username = (TextView) findViewById(R.id.username);
        email = (TextView) findViewById(R.id.email);
        dob = (TextView) findViewById(R.id.dob);
        imgProfile = (ImageView) findViewById(R.id.img_profile);
        name = (TextView) findViewById(R.id.name);

        school = (EditText) findViewById(R.id.school);
        address = (EditText) findViewById(R.id.address);
        phoneno = (EditText) findViewById(R.id.phoneno);
        username.setText(SharedPrefManager.getInstance(this).getUsername());
        email.setText(SharedPrefManager.getInstance(this).getEmail());
        name.setText(SharedPrefManager.getInstance(this).getFirstName() + " " + SharedPrefManager.getInstance(this).getLastName());

        DateEdit.setText(SharedPrefManager.getInstance(this).getDob());
        school.setText(SharedPrefManager.getInstance(this).getSchool());
        phoneno.setText(SharedPrefManager.getInstance(this).getPhone());
        address.setText(SharedPrefManager.getInstance(this).getAddress());
        Bitmap icon = BitmapFactory.decodeResource(getResources(), R.drawable.profile1);



        imgProfile.setImageBitmap(icon);

    }

    public void showTruitonDatePickerDialog(View v) {
        DialogFragment newFragment = new DatePickerFragment();
        newFragment.show(getSupportFragmentManager(), "datePicker");
    }

    public static class DatePickerFragment extends DialogFragment implements
            DatePickerDialog.OnDateSetListener {

        @RequiresApi(api = Build.VERSION_CODES.N)
        @Override
        public Dialog onCreateDialog(Bundle savedInstanceState) {
            // Use the current date as the default date in the picker
            final Calendar c = Calendar.getInstance();
            int year = c.get(Calendar.YEAR);
            int month = c.get(Calendar.MONTH);
            int day = c.get(Calendar.DAY_OF_MONTH);

            // Create a new instance of DatePickerDialog and return it
            return new DatePickerDialog(getActivity(), this, year, month, day);
        }

        public void onDateSet(DatePicker view, int year, int month, int day) {
            // Do something with the date chosen by the user
            DateEdit.setText(day + "/" + (month + 1) + "/" + year);
        }
    }

    public void function(View view){
        Toast.makeText(getApplicationContext(), "hi", Toast.LENGTH_SHORT).show();
    }

    public void updateprofile(View view) {


        final String add=address.getText().toString();
        final String phn=phoneno.getText().toString();
        final String sch=school.getText().toString();
        final String date=DateEdit.getText().toString();
        progressDialog.setMessage("Updating Profile");
        progressDialog.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                Constants.URL_UPDATE,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        progressDialog.dismiss();
                        String Message = "Message";
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            System.out.println(jsonObject);
                            Toast.makeText(getApplication(), jsonObject.getString("message"), Toast.LENGTH_LONG).show();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressDialog.hide();
                        Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("Address", add);
                params.put("Phone", phn);
                params.put("Dob", date);
                params.put("School", sch);
                return params;
            }
        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }
}
