package ticketrecognition.web;

import ticketrecognition.Role;

import javax.annotation.security.PermitAll;
import javax.annotation.security.RolesAllowed;
import javax.ejb.EJB;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.SecurityContext;

@Path("/")
@RolesAllowed({Role.AD_CODE, Role.SCANNER_CODE})
public class TestResource {

    @EJB
    TestService service;

    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public TestClass getTest() {
        return service.testObj();
    }

    @Path("/context")
    @GET
    @PermitAll
    public String getRoles(@Context SecurityContext securityContext) {
        String value = "name: " + securityContext.getUserPrincipal().getName() + "\n";
        value += "is in admin role: " + securityContext.isUserInRole(Role.AD_CODE) + "\n";
        value += "is in scanner role: " + securityContext.isUserInRole(Role.SCANNER_CODE);
        return value;
    }
}