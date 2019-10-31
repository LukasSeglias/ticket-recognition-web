package ticketrecognition;

import java.util.HashMap;
import java.util.Map;

public enum Role {
    ADMIN,

    SCANER;

    public static final String AD_CODE = "admin";
    public static final String SCANNER_CODE = "scanner";
    private static final Map<String, Role> MAPPING = new HashMap<>();

    static {
        MAPPING.put(AD_CODE, ADMIN);
        MAPPING.put(SCANNER_CODE, SCANER);
    }
}
