package ticketrecognition.web;

import ticketrecognition.Role;

import javax.annotation.security.PermitAll;
import javax.annotation.security.RolesAllowed;
import javax.ejb.Stateless;
import javax.inject.Inject;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

@Path("/")
@RolesAllowed({Role.AD_CODE, Role.SCANNER_CODE})
@Stateless
public class TestResource {

    @Inject
    TestService service;

    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public TestClass getTest() {
        return service.testObj();
    }
}