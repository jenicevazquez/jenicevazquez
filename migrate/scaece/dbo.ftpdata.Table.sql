/****** Object:  Table [dbo].[ftpdata]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ftpdata](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[archivo] [varchar](800) NULL,
	[creado] [int] NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[lastmodified] [varchar](50) NULL,
	[hashFile] [varchar](50) NULL,
	[procesado] [int] NULL,
	[idpedimento] [int] NULL,
	[procesando] [int] NULL CONSTRAINT [DF_ftpdata_procesando]  DEFAULT ((0)),
	[mac] [varchar](50) NULL,
	[tipo] [int] NULL CONSTRAINT [DF_ftpdata_tipo]  DEFAULT ((0)),
	[licencia] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
