package ticketrecognition.web.image;

import ticketrecognition.Role;

import javax.annotation.security.RolesAllowed;
import javax.ws.rs.Consumes;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.core.MediaType;
import java.io.IOException;
import java.io.InputStream;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;

@Path("/images")
@RolesAllowed({Role.AD_CODE})
public class ImageResource {

    @POST
    @Path("/{file_name}")
    @Consumes(MediaType.APPLICATION_OCTET_STREAM)
    public void upload(InputStream image, @PathParam("file_name") String filename) throws IOException {
        java.nio.file.Path targetPath = Paths.get(System.getProperty("java.io.tmpdir"), filename);
        Files.copy(image, targetPath, StandardCopyOption.REPLACE_EXISTING);
    }
}
