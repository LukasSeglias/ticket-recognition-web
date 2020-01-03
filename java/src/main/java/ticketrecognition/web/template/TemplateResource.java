package ticketrecognition.web.template;

import ticketrecognition.Role;
import ticketrecognition.dto.TemplateDto;

import javax.annotation.security.RolesAllowed;
import javax.inject.Inject;
import javax.ws.rs.*;
import javax.ws.rs.core.MediaType;
import java.io.IOException;

@Path("/templates/")
@RolesAllowed({Role.AD_CODE})
public class TemplateResource {

    private TemplateService service;

    @POST
    @Consumes(MediaType.APPLICATION_JSON)
    public void create(TemplateDto templateDto) throws IOException {
        service.create(templateDto);
    }

    @DELETE
    @Path("/{templateKey}")
    public void delete(@PathParam("templateKey") String templateKey) {
        service.delete(templateKey);
    }

    @Inject
    void setService(TemplateService service) {
        this.service = service;
    }
}
